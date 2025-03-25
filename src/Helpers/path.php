<?php

if (! function_exists('base_path')) {
    function base_path($path=null) {
        $base =  dirname(dirname(__DIR__));
        return $path?$base.$path:$base;
    }
}

if (! function_exists('app_path')) {
    function app_path($path=null) {
        $base =  base_path().'/app';
        return $path?$base.$path:$base;
    }
}

if (! function_exists('project_path')) {
    function project_path($path=null) {
        $base =  base_path().'/project';
        return $path?$base.$path:$base;
    }
}

if (! function_exists('route_path')) {
    function route_path($path=null) {
        $base =  project_path().'/route';
        return $path?$base.$path:$base;
    }
}

if (! function_exists('src_path')) {
    function src_path($path=null) {
        $base =  base_path('/src');
        return $path?$base.$path:$base;
    }
}

if (! function_exists('core_path')) {
    function core_path($path=null) {
        $base = src_path().'/Core';
        return $path?$base.$path:$base;
    }
}

if (! function_exists('config_path')) {
    function config_path($path=null) {
        $base = base_path().'/config';
        return $path?$base.$path:$base;
    }
}

if (! function_exists('public_path')) {
    function public_path($path=null) {
        $base = base_path().'/public';
        return $path?$base.$path:$base;
    }
}

if (! function_exists('storage_path')) {
    function storage_path($path=null) {
        $base = base_path().'/storage';
        return $path?$base.$path:$base;
    }
}
