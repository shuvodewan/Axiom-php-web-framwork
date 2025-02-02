<?php

namespace App\middlewares;

use Contract\MiddlewareContract;
use Facade\Auth;
use Facade\Response;

class AuthMiddleware implements MiddlewareContract
{
    
    static function handle($request,$next){
        if(!Auth::id()){
            session()->set('error','Please login to continue');
            Response::redirect('/auth/login')->send();
        }
        $next($request);
    }
}
