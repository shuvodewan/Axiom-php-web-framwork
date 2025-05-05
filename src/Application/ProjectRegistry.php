<?php

namespace Axiom\Application;

/**
 * Application registry that maintains system-wide configurations and components.
 * 
 * This class serves as a central registry for installed applications and route groups,
 * providing static configuration for the entire project.
 */
class ProjectRegistry
{
    /**
     * An array of installed application classes that should be initialized.
     * Each entry should be a fully qualified class name of an application.
     * 
     * @var array<class-string>
     */
    static $INSTALLED_APPS = [
       
    ];

    /**
     * Route group configurations with their respective settings.
     * 
     * Format:
     * [
     *     'group_name' => [
     *         'middlewares' => array of middleware identifiers,
     *         'prefix' => route prefix string
     *     ]
     * ]
     * 
     * @var array<string, array{middlewares: string[], prefix: string}>
     */
    static $GROUPS = [
    ];


    /**
     * Template filters to be registered with the templating engine.
     * 
     * Format:
     * [
     *     'filter_name' => callable filter implementation,
     * ]
     * 
     * @var array<string, callable|array<string, string>>
     */
    public function getTemplateFilters()
    {
        return[];
    }

    /**
     * Template functions to be registered with the templating engine.
     * 
     * Format:
     * [
     *     'function_name' => callable function implementation,
     * ]
     * 
     * @var array<string, callable|array<string, string>>
     */
     public function getTemplateFunctions()
    {
        return[];
    }


    /**
     * Bootstraps the registry by initializing dependencies.
     * 
     * This method should be called during system startup to register any required
     * services or components defined in the registry.
     * 
     * @return void
     */
    public static function boot(){
        //register dependencies
    }

    
}