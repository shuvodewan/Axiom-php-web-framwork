<?php

namespace Core\drivers\database;

use Exception;
use PDO;
use PDOException;

class Sql
{

    protected $pdo;
        

    public function __construct(array $config=[])
    {
        try {
            $host      = $config['host'];
            $port      = $config['port'];
            $database  = $config['database'];
            $username  = $config['username'];
            $password  = $config['password'];

            $this->pdo = new PDO("mysql:host=".$host.";port=".$port.";dbname=".$database.";charset=utf8mb4", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

            return $this->pdo;

        } catch (PDOException $e) {
            throw new Exception("Database connection failed: " . $e->getMessage(),$e->getCode(),$e);
        }
    }
}

