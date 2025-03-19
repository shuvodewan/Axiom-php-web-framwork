<?php

namespace Axiom\Application;

use Axiom\Facade\Str;

/**
 * AppManager Class
 *
 * Manages the registration and validation of applications within the framework.
 * This class provides functionality to check if an application is registered.
 */
class AppManager
{
    /**
     * List of registered applications.
     *
     * @var array
     */
    protected array $registered = [];

    /**
     * AppManager Constructor
     *
     * Initializes the list of registered applications from the configuration.
     */
    public function __construct()
    {
        $this->registered = config('app.applications',[]);
    }

    /**
     * Check if an application is registered.
     *
     * @param string $name The name of the application to check
     * @return bool True if the application is registered, false otherwise
     */
    public function isRegistered(string $name): bool
    {
        return in_array('app.' . Str::toLower($name), $this->registered);
    }

    public function getEntityDirs(){
        return array_map(function($app){
            return base_path('/apps/' . str_replace('app.', '', ucfirst($app)) . '/Entities');
        },$this->registered);
    }
}