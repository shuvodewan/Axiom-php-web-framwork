<?php

namespace Axiom\Views;

use Axiom\Facade\Vite;

class TwigMethods

{
    public function php($function, ...$args) 
    {
        if (function_exists($function)) {
            return $function(...$args);
        }
        return null;
    }

    public function vite(array $resouces= []) 
    {
        return Vite::load($resouces);
    }

    public function route(string $name, array $params= []) 
    {
        return route($name,$params);
    }

    public function config(string $name) 
    {
        return config($name);
    }

    public function env(string $name) 
    {
        return env($name);
    }
}