<?php

namespace Axiom\Project;

use App\Authentication\AuthenticationApp;
use App\Axiom\AxiomApp;
use App\Dashboard\DashboardApp;
use Axiom\Application\ProjectRegistry;

/**
 * Application registry that maintains system-wide configurations and components.
 * 
 * This class serves as a central registry for installed applications and route groups,
 * providing static configuration for the entire project.
 */
class Registry extends ProjectRegistry
{
    /**
     * An array of installed application classes that should be initialized.
     * Each entry should be a fully qualified class name of an application.
     * 
     * @var array<class-string>
     */
    static $INSTALLED_APPS = [
        AuthenticationApp::class,
        AxiomApp::class,
        DashboardApp::class
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
        'global'=>[
            'middlewares'=>['admin'],
            'prefix'=>'global'
        ],

        'admin'=>[
            'middlewares'=>[],
            'prefix'=>'admin'
        ]
    ];

}