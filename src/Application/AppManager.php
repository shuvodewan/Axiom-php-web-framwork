<?php

namespace Axiom\Application;

use Axiom\Application\Actions\RegisterRoutes;
use Axiom\Facade\Str;
use Axiom\Http\Router;
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
     * @var array<string, object> Array of application instances keyed by app name
     */
    public static array $apps = [];

    /**
     * AppManager Constructor
     *
     * Initializes the list of registered applications from the configuration.
     */
    public function __construct()
    {
        $this->load();
    }


    /**
     * boot all installed applications from registry.
     *
     * @return self
     */
    public function boot() :self
    {
        foreach(self::$apps as $app){
            $app->boot();
        }
        return $this;
    } 

    /**
     * Loads all installed applications from registry.
     *
     * @return self
     */
    private function load(): self
    {
        foreach (Registry::$INSTALLED_APPS as $app) {
            $obj = new $app();
            $appName = strtolower(str_replace('App', '', (new \ReflectionClass($obj))->getShortName()));
            self::$apps[$appName] = $obj;
        }

        return $this;
    }

    /**
     * Gets all registered application names.
     *
     * @return array<string> Array of application names
     */
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

    /**
     * Gets entity directories for all applications.
     *
     * @return array<string> Array of entity directory paths
     */
    public function getEntityDirs(): array
    {
        return array_map(function (string $app) {
            return app_path('/' . ucfirst($app) . '/' . self::$apps[$app]->entities);
        }, $this->getAppsName());
    }

    /**
     * Gets controller directories for all applications.
     *
     * @return array<object> Array of application objects with dir and name properties
     */
    public function getControllerDirs(): array
    {
        return array_map(function (string $app) {
            $appObj = self::$apps[$app];
            $appObj->dir = app_path('/' . ucfirst($app) . '/' . self::$apps[$app]->controllers);
            $appObj->name = $app;
            return $appObj;
        }, $this->getAppsName());
    }


    public function getJobs(): array
    {
        return array_merge(...array_map(function (string $app) {
            $appObj = self::$apps[$app];
            return $appObj->registerJobs();
        }, $this->getAppsName()));
    }

    /**
     * Registers routes for all applications.
     */
    public function registerRoute(): void
    {
        (new RegisterRoutes())->load($this->getControllerDirs());
    }

}