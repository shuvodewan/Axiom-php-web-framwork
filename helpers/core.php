<?php

use Carbon\Carbon;
use Core\Application;
use Core\Session;
use Core\Storage;
use Core\facade\Config;
use Core\facade\Hash;
use Core\facade\Request;

if (! function_exists('env')) {
    function env($key, $default=null) {
        $value = Application::getInstance()->getEnv($key);
        if($value == 'true' || $value=='false'){
            $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }
        return $value??$default;
    }
}

if (!function_exists('dd')) {
    function dd(...$vars)
    {
        foreach ($vars as $var) {
            echo "<pre>";
            var_dump($var);
            echo "</pre>";
        }
        die(1);
    }
}

if (! function_exists('config')) {
    function config($key, $default=null) {
        $value = Config::get($key, $default);
        return $value??$default;
    }
}

if (! function_exists('session')) {
    function session() {
        return (new Session());
    }
}

if (! function_exists('csrf_token')) {
    function csrf_token() {
        $token = Hash::make(random_bytes(32));
        session()->set('csrf_token',[
            'token'=>$token,
            'expire_at' => Carbon::now()->addMinutes((int)config('app.csrf_expire_time'))->toDateTimeString()
        ]);

        return $token;
    }
}

if (! function_exists('assets')) {
    function assets($file_path) {
        return config('app.url').'/'.$file_path;
    }
}

if (! function_exists('storage')) {
    function storage() {
        return new Storage();
    }
}

if (! function_exists('errors')) {
    function errors($key) {
        if($errors = session()->get(Request::getUri())){
            return isset($errors[$key])?$errors[$key][0]:null;
        }
    }
}

if (! function_exists('setErrorsToResponse')) {
    function setErrorsToResponse($key,$mesage) {
        if($errors = session()->get(Request::getUri())){
            return isset($errors[$key])?$errors[$key][0]:null;
        }
    }
}