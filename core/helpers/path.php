<?php

if (! function_exists('base_path')) {
    function base_path($path=null) {
        $base =  dirname(__DIR__);
        return $path?$base.$path:$base;
    }
}

if (! function_exists('app_path')) {
    function app_path($path=null) {
        $base =  dirname(__DIR__).'/app';
        return $path?$base.$path:$base;
    }
}

if (! function_exists('core_path')) {
    function core_path($path=null) {
        $base = dirname(__DIR__).'/core';
        return $path?$base.$path:$base;
    }
}

if (! function_exists('config_path')) {
    function config_path($path=null) {
        $base = dirname(__DIR__).'/config';
        return $path?$base.$path:$base;
    }
}

if (! function_exists('route_path')) {
    function route_path($path=null) {
        $base = dirname(__DIR__).'/route';
        return $path?$base.$path:$base;
    }
}

if (! function_exists('public_path')) {
    function public_path($path=null) {
        $base = dirname(__DIR__).'/public';
        return $path?$base.$path:$base;
    }
}

if (! function_exists('storage_path')) {
    function storage_path($path=null) {
        $base = dirname(__DIR__).'/storage';
        return $path?$base.$path:$base;
    }
}
