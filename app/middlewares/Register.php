<?php

namespace App\middlewares;

class Register{
    
    static $middlewares=[
        'web'=>[
            StartSessionMiddleware::class,
            CsrfProtectionMiddleware::class
        ],
        'guest'=>GuestMiddleware::class,
        'auth'=>AuthMiddleware::class,
    ]; 


    static function getMiddleware($alias){
        return isset(self::$middlewares[$alias])?self::$middlewares[$alias]:null;
    }
}
