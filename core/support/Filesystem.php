<?php

namespace Core\support;

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

    public function __construct($disk=null)
    {
        $this->disk = !$disk?config('filesystem.default'):$disk;

        $this->setDriver();
    }

    public function disk(string $name)
    {
        $this->disk = $name;
        return $this->setDriver();
    }

    public function getDisk(string $name)
    {
        return $this->disk;
    }

    public function get(string $path)
    {
        return $this->setDriver()->read($this->setDiskPath($path));
    }

    public function put(string $contents,$path = null)
    {
        return $this->setDriver()->write($this->setDiskPath($path), $contents);
    }

    public function setDiskPath($path = null){
        return trim($path,'/');
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

    public function url(){
        return $this->setDriver()->getUrl();
    }

    private function setDriver(){
        $driver = config('filesystem.disks.' . $this->disk . '.driver');
        if(!array_key_exists($driver,$this->registerDrivers)){
            throw new Exception("$driver driver not found");
        }

        if(!array_key_exists($driver,$this->drivers)){
            $this->drivers[$driver] = new $this->registerDrivers[$driver](config('filesystem.disks.' . $this->disk));
        }

        return $this->drivers[$driver];
    }
}