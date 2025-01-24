<?php

namespace Core;

use Traits\EnvironmentTrait;

class Application
{

    use EnvironmentTrait;

    static $instance;

    public function __construct()
    {
        self::setInstance($this);
        $this->loadEnv()->setConfig();
        return $this;
    }

    static function setInstance($instance){
        self::$instance = $instance;
    }

    static function getInstance(){
        return self::$instance;
    }

    public function setConfig(){
        new Config();
        return $this;
    }

    public function init(){
        Request::setInstance()->capture();
        return $this;
    }

    public function send(){
        Request::setInstance()->capture();
        return $this;
    }
}