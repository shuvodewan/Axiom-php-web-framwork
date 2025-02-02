<?php

namespace Core;

use Carbon\Carbon;
use stdClass;

abstract class Model
{
    protected static $table;
    protected static $pdo;
    protected static $raw;
    protected $attributes=null;

    protected static function connect()
    {
        static::$pdo = Database::getInstance();
    }

    abstract static function setTable();

    protected static function boot(){
        static::connect();
        static::setTable();
    }

    protected static function mutation(&$data,$type='create'){

        if($type){
            $data['created_at'] = Carbon::now();
            $data['updated_at'] = Carbon::now();
        }else{
            $data['updated_at'] = Carbon::now();
        }
    }

    static function getTable(){
        return static::$table;
    }

    public function __get($key)
    {
        if ($this->attributes && property_exists($this->attributes,$key)) {
            return $this->attributes->$key;
        }
        return null;
    }

    public function __set($key, $value)
    {
        if (! $this->attributes) {
            
            $this->attributes = new stdClass();
        }
        $this->attributes->$key = $value;
    }

    static function raw(){
        static::$raw = true;
    }

    public static function all()
    {
        $stmt = static::$pdo->query("SELECT * FROM " . static::getTable());
        return $stmt->fetchAll();
    }

    public static function find($id, $raw=false)
    {
        self::boot();
        $stmt = static::$pdo->prepare("SELECT * FROM " . static::getTable() . " WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $raw?$row:self::hydrate($row);
    }
    

    static function create($data,$raw=false)
    {
        self::boot();
        self::mutation($data);

        $columns = implode(',', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));
        $stmt = static::$pdo->prepare("INSERT INTO " . static::getTable() . " ($columns) VALUES ($values)");
        $stmt->execute($data);
        return self::find(static::$pdo->lastInsertId());
    }


    public function update($id, $data)
    {
        self::boot();
        self::mutation($data,'update');

        $set = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($data)));
        $data['id'] = $this->id;

        $stmt = static::$pdo->prepare("UPDATE " . static::getTable() . " SET $set WHERE id = :id");
        return $stmt->execute($data);
    }

    public function delete()
    {
        $stmt = static::$pdo->prepare("DELETE FROM " . static::getTable() . " WHERE id = :id");
        return $stmt->execute(['id' => $this->id]);
    }

    static function hydrate($rows){
        if(is_array($rows)){
            return array_map(function($row){
                return static::makeModelObject($row);
            },$rows);
        }
        return static::makeModelObject($rows);
    }

    private static function makeModelObject($row){
        $model = new static();
        $model->attributes = $row;
        return $model;
    }
}