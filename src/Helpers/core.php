<?php

use Carbon\Carbon;
use Core\Application;
use Core\console\Preview;
use Core\facade\Config;
use Core\facade\Hash;
use Core\facade\Request;
use Core\http\Session;
use Core\support\Filesystem;

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
        if(Application::getInstance()->isConsole()){
            foreach ($vars as $var) {
              Preview::render($var);
            }
        }else{
            echo '<style>';
            echo '    body { font-family: "Arial", sans-serif; margin: 0; padding: 0; background-color: #333; color: #fff; font-size: 14px; }';
            echo '    .dd-container { padding: 20px; max-width: 900px; margin: 50px auto; background-color: #222; border-radius: 5px; }';
            echo '    pre { color: #fff; background-color: #222; padding: 10px; border-radius: 3px; overflow-x: auto; }';
            echo '    code { color: #ffcc00; font-size: 14px; }';
            echo '    .dd-header { font-size: 20px; color: #ffcc00; padding-bottom: 10px; }';
            echo '</style>';
    
            echo '<div class="dd-container">';
            echo '<div class="dd-header">Dumped Variables:</div>';
    
            foreach ($vars as $var) {
                echo "<pre>";
                var_dump($var);
                echo "</pre>";
            }
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
        return new Filesystem();
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
