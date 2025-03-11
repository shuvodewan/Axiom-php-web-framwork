<?php

namespace Core\application\repository;

use Carbon\Carbon;
use Core\contract\RepositoryContract;
use Core\Database;
use Core\Model;

class SqlRepository implements RepositoryContract
{
    private $connection = 'sql';

    protected $db;

    protected $table;

    protected $model;

    public function __construct(Model $model, string $table)
    {
        $this->model = $model;
        $this->table = $table;
        $this->db = (new Database())->connect($this->connection);
    }

    public function db(){
        return $this->db;
    }

    public function getTable(){
        return $this->table;
    }

    public function mutation(&$data, $type='create') {
        if ($type) {
            $data['created_at'] = Carbon::now();
            $data['updated_at'] = Carbon::now();
        } else {
            $data['updated_at'] = Carbon::now();
        }
    }

    public function all($raw = false,$paginate = false, $page = 1, $perPage = 15) {
        
        if($paginate){
            $offset = ($page - 1) * $perPage;
            $stmt = $this->db->prepare("SELECT * FROM " . $this->getTable() . " LIMIT :limit OFFSET :offset");
            $stmt->bindParam(':limit', $perPage, \PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        }else{
            $stmt = $this->db->query("SELECT * FROM " . static::getTable());
        }
        $stmt->execute();
        $rows = $stmt->fetchAll();

        return $raw ? $rows : $this->hydrate($rows);
    }

    public function paginate($page = 1, $perPage = 15, $raw = false) {
        $data = $this->all(true, $page, $perPage, $raw);
        $total = $this->count();
        $totalPages = ceil($total / $perPage);

        return [
            'data' => $data,
            'current_page' => $page,
            'per_page' => $perPage,
            'total' => $total,
            'total_pages' => $totalPages,
        ];
    }

    public function count() {
        $stmt = $this->db->query("SELECT COUNT(*) AS total FROM " . $this->getTable());
        $row = $stmt->fetch();
        return $row['total'];
    }

    public function find($id, $raw = false) {
        $stmt = $this->db->prepare("SELECT * FROM " . $this->getTable() . " WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $raw ? $row : $this->hydrate($row);
    }

    public function create($data, $raw = false) {
        self::mutation($data);
        $columns = implode(',', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));
        $stmt = $this->db->prepare("INSERT INTO " . $this->getTable() . " ($columns) VALUES ($values)");
        $stmt->execute($data);
        return $this->find($this->db->lastInsertId(), $raw);
    }

    public function update($id, $data) {
        self::mutation($data, 'update');
        $set = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($data)));
        $data['id'] = $id;

        $stmt = $this->db->prepare("UPDATE " . $this->getTable() . " SET $set WHERE id = :id");
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM " . $this->getTable() . " WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function hydrate($rows) {
        if (is_array($rows)) {
            return array_map(function ($row) {
                return static::makeModelObject($row);
            }, $rows);
        }
        return static::makeModelObject($rows);
    }

    public function makeModelObject($row) {
        $model = new Model();
        $model->attributes = $row;
        return $model;
    }
}