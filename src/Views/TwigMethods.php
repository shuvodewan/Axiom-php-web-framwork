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
}