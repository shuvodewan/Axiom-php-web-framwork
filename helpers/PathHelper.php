<?php

if (! function_exists('base_path')) {
    function base_path($path=null) {
        $base =  dirname(__DIR__);
        return $path?$base.$path:$base;
    }
}

if (! function_exists('core_path')) {
    function core_path($path=null) {
        $base = dirname(__DIR__).'/core';
        return $path?$base.$path:$base;
    }
}