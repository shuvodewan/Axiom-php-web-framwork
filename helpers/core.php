<?php

use Carbon\Carbon;
use Core\Application;
use Core\Session;
use Facade\Config;
use Facade\Hash;

if (! function_exists('env')) {
    function env($key, $default=null) {
        $value = Application::getInstance()->getEnv($key);
        if($value == 'true' || $value=='false'){
            $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }
        return $value??$default;
    }
}

if (! function_exists('config')) {
    function config($key, $default=null) {
        $value = Config::get($key, $default);
        return $value??$default;
    }
}

if (! function_exists('session')) {
    function session($key, $default=null) {
        return Session::getInstance();
    }
}

if (! function_exists('csrf_token')) {
    function csrf_token() {
        $token = Hash::make(random_bytes(32));
        Session::getInstance()->set('csrf_token',[
            'token'=>$token,
            'expires_at' => Carbon::now()->addMinutes(config('app.csrf_expire_time'))->toDateTimeString()
        ]);

        return $token;
    }
}

if (! function_exists('assets')) {
    function assets($file_path) {
        return config('app.url').'/'.$file_path;
    }
}