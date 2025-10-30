<?php

use Axiom\Core\Application;
use Axiom\Core\Container;
use Axiom\Facade\Config;
use Axiom\Facade\Hash;
use Axiom\Facade\Request;
use Axiom\Filesystem\FileManager;
use Axiom\Http\Router;
use Axiom\Http\Session;
use Axiom\Support\DD;
use Carbon\Carbon;

if (! function_exists('env')) {
    /**
     * Get an environment variable value with optional default
     *
     * @param string $key The environment variable key
     * @param mixed $default Default value if key doesn't exist
     * @return mixed The environment value or default
     */
    function env($key, $default=null) {
        $value = Application::getInstance()->getEnv($key);
        if($value == 'true' || $value=='false'){
            $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }
        return $value??$default;
    }
}

if (!function_exists('dd')) {
    /**
     * Dump variables and end execution (Dump & Die)
     * 
     * @param mixed ...$vars Variables to dump
     * @return never
     */
    function dd(...$vars)
    {
        (new DD())->run($vars);
    }
}

if (! function_exists('config')) {
    /**
     * Get a configuration value with optional default
     *
     * @param string $key Configuration key in dot notation
     * @param mixed $default Default value if key doesn't exist
     * @return mixed The configuration value or default
     */
    function config($key, $default=null) {
        $value = Config::get($key, $default);
        return $value??$default;
    }
}

if (! function_exists('session')) {
    /**
     * Get the session manager instance
     *
     * @return Session The session manager instance
     */
    function session() {
        return (new Session());
    }
}

if (! function_exists('csrf_token')) {
    /**
     * Generate and store a CSRF token
     *
     * @return string The generated CSRF token
     */
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
    /**
     * Generate a URL for an asset file
     *
     * @param string $file_path The asset file path relative to public directory
     * @return string The full URL to the asset
     */
    function assets($file_path) {
        return config('app.url').'/'.$file_path;
    }
}

if (! function_exists('route')) {
    /**
     * Generate a URL for an asset file
     *
     * @param string $file_path The asset file path relative to public directory
     * @return string The full URL to the asset
     */
    function route($name, $params=[]) {
        return config('app.url') . '/' . Router::getInstance()->getNameRoute($name,$params);
    }
}

if (! function_exists('storage')) {
    /**
     * Get the file manager instance
     *
     * @return FileManager The file manager instance
     */
    function storage() {
        return new FileManager();
    }
}

if (! function_exists('errors')) {
    /**
     * Get validation error message for a field
     *
     * @param string $key The field name
     * @return string|null The error message or null if no error exists
     */
    function errors($key) {
        if($errors = session()->get(Request::getUri())){
            return isset($errors[$key])?$errors[$key][0]:null;
        }
    }
}

if (! function_exists('setErrorsToResponse')) {
    /**
     * Set error messages to be returned in response
     *
     * @param string $key The field name
     * @param string $message The error message
     * @return string|null The error message or null if no error exists
     */
    function setErrorsToResponse($key,$mesage) {
        if($errors = session()->get(Request::getUri())){
            return isset($errors[$key])?$errors[$key][0]:null;
        }
    }
}

if (! function_exists('di')) {
    /**
     * Get the dependency injection container instance
     *
     * @return Container The container instance
     */
    function di() {
        return Container::getInstance();
    }
}

if (! function_exists('getNameSpaceFromFile')) {
    /**
     * Extract namespace from a PHP file
     *
     * @param string $filePath Path to the PHP file
     * @return string The extracted namespace or empty string if none found
     */
    function getNameSpaceFromFile($filePath) {
        $tokens = token_get_all(file_get_contents($filePath));
        $namespace = '';
        $inNamespace = false;
    
        foreach ($tokens as $token) {
            if (is_array($token)) {
                if ($token[0] === T_NAMESPACE) {
                    $inNamespace = true;
                } elseif ($inNamespace && $token[0] === T_STRING) {
                    $namespace .= $token[1] . '\\';
                } elseif ($inNamespace && $token[0] === T_WHITESPACE) {
                    // Do nothing
                } elseif ($inNamespace && $token[0] === T_NS_SEPARATOR) {
                    $namespace .= '\\';
                } else {
                    $inNamespace = false;
                }
            } elseif ($token === ';' || $token === '{') {
                $inNamespace = false;
            }
        }
    
        return rtrim($namespace, '\\');
    }
}