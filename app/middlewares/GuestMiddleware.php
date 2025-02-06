<?php

namespace App\middlewares;

use Contract\MiddlewareContract;
use Core\facade\Auth;
use Core\facade\Response;

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
