<?php

namespace App\Dashboard;

use Axiom\Application\App;

class DashboardApp extends App
{
    /**
     * An optional route group prefix for all application routes.
     * If set, all routes will be nested under this group.
     * 
     * @var string|null
     */
    public ?string $group = 'admin';

    /**
     * If true, all routes will automatically be grouped under the application name.
     * Useful for API versioning or modular routing.
     * 
     * @var bool
     */
    public bool $appRoute = true;
}