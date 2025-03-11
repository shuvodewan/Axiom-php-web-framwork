<?php

namespace Core;

use Core\drivers\database\Sql;
use Exception;

class Database
{

    protected $drivers = [
        'sql'=>Sql::class
    ];

    protected $connection;


    public function connect($connection=null){
        
        if(!$config = config('database.' . ($connection??config('database.default')))){
            throw new Exception('Connection not found');
        }


        if(!in_array($config['driver'], $this->drivers)){
            throw new Exception('Driver not found');
        }

        $driver = $this->drivers[$config['driver']];

        if(!$this->connection instanceof $driver){
            $this->connection = new ($config);
        }

        return $this->connection;

    }

   
}