<?php

namespace App\middlewares;

class Register{
    
    static $middlewares=[
        'web'=>[
            StartSessionMiddleware::class
        ]
    ]; 
}
