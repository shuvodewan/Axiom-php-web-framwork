<?php

if (! function_exists('template_path')) {
    function template_path($path=null) {
        $base = app_path('/views/template');
        return $path?$base.$path:$base;
    }
}

if (! function_exists('layout_path')) {
    function layout_path($path=null) {
        $base = template_path('/layouts');
        return $path?$base.$path:$base;
    }
}