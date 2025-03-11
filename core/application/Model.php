<?php

namespace Core;

use Core\application\repository\SqlRepository;
use stdClass;

abstract class Model
{
    private static $table;
    protected static $db;
    protected static $repository = SqlRepository::class;

    protected $attributes=null;

    protected static function connect()
    {
        self::$db = new self::$repository(static::class, self::$table);
        return self::$db;
    }

    abstract static function setTable();


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

    public static function all($raw = false,$paginate = false, $page = 1, $perPage = 15)
    {
        return self::connect()->all($raw,$paginate,$page,$perPage);
    }

    public static function find($id,$raw=false)
    {
        return self::connect()->find($id,$raw);
    }
    

    static function create($data,$raw=false)
    {
        return self::connect()->create($data,$raw);
    }


    public function update($data)
    {
        return self::connect()->update($this->id,$data);
    }

    public function delete()
    {
        return self::connect()->delete($this->id);
    }

}