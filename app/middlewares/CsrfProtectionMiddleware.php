<?php

namespace App\middlewares;

use App\exception\PageExpireException;
use Carbon\Carbon;
use Contract\MiddlewareContract;
use Core\Session;
use Exception;

class CsrfProtectionMiddleware implements MiddlewareContract
{
    
    static function handle($request,$next){
        if($request->method=='post'){
            if(!$token = Session::getInstance()->get(self::getCsrfToken($request))){
                throw new Exception('Page Expired');
            }else{
                if(self::verify_csrf($token)){
                    $next($request);
                }
            }
            throw new Exception('Page Expired');
        } 

        $next($request);
    }


    static function getCsrfToken($request){
        return $request->getHeader('x-csrf-token')??$request->getBody('csrf_token');
    }


    static function verify_csrf($token){
        if($csrf_token = session('csrf_token')){
           return hash_equals($csrf_token['token'], $token) && Carbon::now()->greaterThan(Carbon::parse($csrf_token['expire_time']));
        }
    }
}
