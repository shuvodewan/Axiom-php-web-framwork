<?php

namespace Core;

use Dotenv\Dotenv;

class Application
{
    static $instance;
    public $value;

    public function __construct()
    {
        $this->value = rand(1,10);
        $this->loadEnv();
        self::setInstance($this);
    }


    static function setInstance($instance){
        self::$instance = $instance;
    }

    static function getInstance(){
        return self::$instance;
    }


    private function loadEnv(){
        $dotenv = Dotenv::createImmutable(base_path());
        $dotenv->safeLoad();

    }
}