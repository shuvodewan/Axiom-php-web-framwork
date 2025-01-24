<?php

use Core\Application;
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