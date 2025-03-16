<?php

namespace Axiom\Project\Middlewares;

use Core\contract\MiddlewareContract;
use Core\facade\Auth;

class GuestMiddleware implements MiddlewareContract
{
    
    static function handle($request,$next){
        if(Auth::id()){
            session()->set('error','Only guest allowed');
            Response::redirect('/')->send();
        }
        $next($request);
    }
}
