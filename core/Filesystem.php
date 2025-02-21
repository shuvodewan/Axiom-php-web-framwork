<?php

namespace Core;

use Core\drivers\filesystem\Local;
use Core\drivers\filesystem\S3;
use Exception;

class Filesystem
{
    protected array $drivers=[];
    protected string $disk;
    protected array $registerDrivers = [
        'local'=>Local::class,
        's3'=>S3::class,
    ];

    public function __construct(string $disk=null)
    {
        $this->disk = !$disk?config('filesystem.default'):$disk;

        $this->setDriver();
    }

    public function disk(string $name)
    {
        $this->disk = $name;
        return $this->setDriver();
    }

    public function get(string $path)
    {
        return $this->setDriver()->read($path);
    }

    public function put(string $path, string $contents)
    {
        $this->setDriver()->write($path, $contents);
    }

    public function delete(string $path)
    {
        $this->setDriver()->delete($path);
    }

    public function instance(){
        return $this;
    }

    public function exists(string $path)
    {
        return $this->setDriver()->fileExists($path);
    }

    private function setDriver(){
        $driver = config('filesystem.' . $this->disk . 'driver');
        if(!array_key_exists($driver,$this->registerDrivers)){
            throw new Exception("$driver driver not found");
        }

        if(!array_key_exists($driver,$this->drivers)){
            $this->drivers[$driver] = new $this->registerDrivers[$driver](config('filesystem.' . $this->disk));
        }

        return $this->drivers[$driver];
    }
}