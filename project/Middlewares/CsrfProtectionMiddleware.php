<?php

namespace Axiom\Project\Middlewares;

use App\exception\PageExpireException;
use Carbon\Carbon;
use Core\contract\MiddlewareContract;
use Core\Session;
use Exception;

class CsrfProtectionMiddleware implements MiddlewareContract
{
    
    static function handle($request,$next){
      
        if($request->method=='post'){
            if(!$token = self::getCsrfToken($request)){
                throw new Exception('Page Expired');
            }else{
                if(self::verify_csrf($token)){
                    return $next($request);
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
        if($csrf_token = session()->get('csrf_token')){
           return hash_equals($csrf_token['token'], $token) && Carbon::now()->lessThan(Carbon::parse($csrf_token['expire_at']));
        }
    }
}
