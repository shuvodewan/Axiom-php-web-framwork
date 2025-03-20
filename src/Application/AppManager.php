<?php

namespace Axiom\Application;

use Axiom\Application\Actions\RegisterRoutes;
use Axiom\Facade\Str;
use Axiom\Project\Registry;
use Axiom\Traits\InstanceTrait;

/**
 * AppManager Class
 *
 * Manages the registration and validation of applications within the framework.
 * This class provides functionality to check if an application is registered.
 */
class AppManager
{
    use InstanceTrait;
    /**
     * List of registered applications.
     *
     * @var array
     */
    static array $apps = [];

    /**
     * AppManager Constructor
     *
     * Initializes the list of registered applications from the configuration.
     */
    public function __construct()
    {
        $this->load();
    }

    private function load(): self
    {
        foreach(Registry::$INSTALLED_APPS as $app){
            $obj = new $app();
            $appName = strtolower(str_replace('App', '',(new \ReflectionClass($obj))->getShortName()));
            self::$apps[$appName] = $obj;
        }

        return $this;
    }

    private function getAppsName(): array
    {
        return array_keys(self::$apps);
    }

    /**
     * Check if an application is registered.
     *
     * @param string $name The name of the application to check
     * @return bool True if the application is registered, false otherwise
     */
    public function isRegistered(string $name): bool
    {
        return in_array(Str::toLower($name), $this->getAppsName());
    }

    public function getEntityDirs(){
        return array_map(function($app){
            return app_path('/'.ucfirst($app) . '/' . self::$apps[$app]->entities);
        },$this->getAppsName());
    }

    public function getControllerDirs(){
        return array_map(function($app){
            return app_path('/'.ucfirst($app) . '/' .self::$apps[$app]->controllers);
        },$this->getAppsName());
    }

    public function registerRoute(): void
    {
        (new RegisterRoutes())->load($this->getControllerDirs());
    }
}