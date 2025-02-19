<?php

namespace Core\traits;

trait SingletonTrait
{
    static $instance;
    static function setInstance($instance){
        return self::$instance = $instance;
    }

    static function getInstance(){
        if(!self::$instance){
            self::setInstance(new self());
        }
        return self::$instance;
    }
}