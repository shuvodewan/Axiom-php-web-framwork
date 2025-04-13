<?php

if (! function_exists('base_path')) {
    /**
     * Get the base path of the application.
     *
     * @param string|null $path Optional path to append to base directory
     * @return string Full path to base directory or base directory + appended path
     */
    function base_path($path = null) {
        $base = dirname(dirname(__DIR__));
        return $path ? $base . $path : $base;
    }
}

if (! function_exists('app_path')) {
    /**
     * Get the application path.
     *
     * @param string|null $path Optional path to append to app directory
     * @return string Full path to app directory or app directory + appended path
     */
    function app_path($path = null) {
        $base = base_path() . '/app';
        return $path ? $base . $path : $base;
    }
}

if (! function_exists('database_path')) {
    /**
     * Get the database path.
     *
     * @param string|null $path Optional path to append to database directory
     * @return string Full path to database directory or database directory + appended path
     */
    function database_path($path = null) {
        $base = base_path() . '/database';
        return $path ? $base . $path : $base;
    }
}

if (! function_exists('project_path')) {
    /**
     * Get the project path.
     *
     * @param string|null $path Optional path to append to project directory
     * @return string Full path to project directory or project directory + appended path
     */
    function project_path($path = null) {
        $base = base_path() . '/project';
        return $path ? $base . $path : $base;
    }
}

if (! function_exists('route_path')) {
    /**
     * Get the route path.
     *
     * @param string|null $path Optional path to append to route directory
     * @return string Full path to route directory or route directory + appended path
     */
    function route_path($path = null) {
        $base = project_path() . '/route';
        return $path ? $base . $path : $base;
    }
}

if (! function_exists('src_path')) {
    /**
     * Get the source path.
     *
     * @param string|null $path Optional path to append to src directory
     * @return string Full path to src directory or src directory + appended path
     */
    function src_path($path = null) {
        $base = base_path('/src');
        return $path ? $base . $path : $base;
    }
}

if (! function_exists('core_path')) {
    /**
     * Get the core path.
     *
     * @param string|null $path Optional path to append to core directory
     * @return string Full path to core directory or core directory + appended path
     */
    function core_path($path = null) {
        $base = src_path() . '/Core';
        return $path ? $base . $path : $base;
    }
}

if (! function_exists('config_path')) {
    /**
     * Get the configuration path.
     *
     * @param string|null $path Optional path to append to config directory
     * @return string Full path to config directory or config directory + appended path
     */
    function config_path($path = null) {
        $base = base_path() . '/config';
        return $path ? $base . $path : $base;
    }
}

if (! function_exists('public_path')) {
    /**
     * Get the public path.
     *
     * @param string|null $path Optional path to append to public directory
     * @return string Full path to public directory or public directory + appended path
     */
    function public_path($path = null) {
        $base = base_path() . '/public';
        return $path ? $base . $path : $base;
    }
}

if (! function_exists('storage_path')) {
    /**
     * Get the storage path.
     *
     * @param string|null $path Optional path to append to storage directory
     * @return string Full path to storage directory or storage directory + appended path
     */
    function storage_path($path = null) {
        $base = base_path() . '/storage';
        return $path ? $base . $path : $base;
    }
}