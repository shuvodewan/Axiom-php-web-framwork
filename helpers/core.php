<?php

use Core\Application;
use Core\Session;
use Facade\Config;

if (! function_exists('env')) {
    function env($key, $default=null) {
        $value = Application::getInstance()->getEnv($key);
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