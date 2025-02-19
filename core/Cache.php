<?php

namespace Core;

use Core\facade\Str;
use Core\traits\SingletonTrait;
use Exception;

class Cache
{
    use SingletonTrait;

    protected $driver;

    public function __construct() {
        $this->setDriver(config('cache.default'));
        self::setInstance($this);
    }

    public function setDriver(string $driver){
        try{
            $className = 'Core\\drivers\\cache\\' . ucfirst(Str::toLower($driver)); 
            $this->driver = new $className();
        }catch(Exception $exception){
            throw new exception('Cannot initiate cache driver '. $driver);
        }
    }

    public function __call(string $method, array $arguments){
        return $this->driver->$method(...$arguments);
    }
}