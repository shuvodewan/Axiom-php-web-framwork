<?php

namespace Axiom\Application;

/**
 * Application configuration class for defining paths, route groups, and middleware.
 */
class App 
{
    /**
     * The base directory path where controller classes are located.
     * Defaults to "Controllers".
     * 
     * @var string
     */
    public string $controllers = "Controllers";

    /**
     * The base directory path where templates are located.
     * Defaults to "Templates".
     * 
     * @var string
     */
    public string $templates = "Templates";

    /**
     * The base directory path where entity classes are located.
     * Defaults to "Entities".
     * 
     * @var string
     */
    public string $entities = 'Entities';

    /**
     * An optional route group prefix for all application routes.
     * If set, all routes will be nested under this group.
     * 
     * @var string|null
     */
    public ?string $group = null;

    /**
     * If true, all routes will automatically be grouped under the application name.
     * Useful for API versioning or modular routing.
     * 
     * @var bool
     */
    public bool $appRoute = false;

    /**
     * An array of middleware to apply globally when `appRoute` is used.
     * Middlewares will be executed in the order they are defined.
     * 
     * @var array<string>
     */
    public array $middlewares = [];

    /**
     * An array of database seeder classes to run when seeding the application.
     * 
     * Seeders will be executed in the order they are defined in this array.
     *
     * @var array<class-string> Array of seeder class names
     */
    public array $seeders = [];

    /**
     * Bootstraps the application by registering container dependencies.
     * This method should be called during application initialization to set up
     * any required services, bindings, or dependencies in the DI container.
     * 
     * @return void
     */
    public function boot(){
        //register container dependencies
    }

    public function registerJobs() :array
    {
        return [];
    }
}