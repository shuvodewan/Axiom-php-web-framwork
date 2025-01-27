<?php

namespace App\middlewares;

use Contract\MiddlewareContract;
use Core\Session;

class StartSessionMiddleware implements MiddlewareContract
{
    
    static function handle($request,$next){
        (new Session())->startSession();
        $next($request);
    }
}
