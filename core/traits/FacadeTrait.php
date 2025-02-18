<?php

namespace Core\traits;

trait FacadeTrait
{
    static $instance;
    
    static function __callStatic($name, $arguments)
    {
        self::$instance = self::getInstance();
        return self::$instance->$name(...$arguments);
    }
}