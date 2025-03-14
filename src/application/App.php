<?php

namespace Core\application;

use Core\facade\Str;

class App
{
    protected $registered = [];


    public function __construct()
    {
        $this->registered = config('app.applications');
    }


    public function isRegistered($name){
        return in_array('app.' . Str::toLower($name),$this->registered);
    }
}