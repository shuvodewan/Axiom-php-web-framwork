<?php

namespace Axiom\Project\Middlewares;

use Core\contract\MiddlewareContract;
use Core\facade\Auth;
use Core\facade\Response;

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
