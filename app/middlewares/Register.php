<?php

namespace App\middlewares;

class Register{
    
    static $middlewares=[
        'web'=>[
            StartSessionMiddleware::class,
            CsrfProtectionMiddleware::class
        ]
    ]; 


    static function getMiddleware($alias){
        return isset(self::$middlewares[$alias])?self::$middlewares[$alias]:null;
    }
}
