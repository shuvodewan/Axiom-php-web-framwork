<?php

namespace Core;


class Storage
{
    protected $disk;

    public function __construct()
    {
        $this->disk = config('disk.default');
    }

    public function url($path){
        return $this->getDiskUrl() .'/'. $this->getDiskPrefix() . $path;
    }

    public function disk($name){
        $this->disk = $name;
    }



    private function getDiskUrl(){
        return config('disk' .'.'. $this->disk .'.url' );
    }

    private function getDiskPrefix(){
        return config('disk' .'.'. $this->disk .'.prefix' );
    }

    private function getDiskPath(){
        return config('disk' .'.'. $this->disk .'.path' );
    }
}