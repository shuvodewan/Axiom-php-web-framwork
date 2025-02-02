<?php

namespace Core;

use Exception;
use PDO;
use PDOException;

class Database
{
    static $instance = null;
    private $pdo;

    public function __construct()
    {
        try {
            $host = config('database.host');
            $port = config('database.port');
            $database = config('database.database');
            $username = config('database.username');
            $password = config('database.password');

            $this->pdo = new PDO("mysql:host=".$host.";port=".$port.";dbname=".$database.";charset=utf8mb4", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: " . $e->getMessage(),$e->getCode(),$e);
        }
    }

    static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }
        return self::$instance->pdo;
    }

    public function isUnique($table, $column, $value)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM $table WHERE $column = :value");
        $stmt->execute([':value' => $value]);
        return $stmt->fetchColumn() != 0;
    }
}