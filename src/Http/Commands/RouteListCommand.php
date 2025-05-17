<?php

namespace Axiom\Http\Commands;

use Axiom\Console\Command;
use Axiom\Http\Router;

/**
 * A console command to display a list of all registered routes in the application.
 *
 * This command compiles and displays a formatted table of all routes registered
 * with the router, including their HTTP methods, URIs, names, actions, and middleware.
 */
class RouteListCommand extends Command
{
    /**
     * The compiled route collection from the router.
     *
     * @var array
     */
    protected $routes;

    /**
     * Create a new RouteListCommand instance.
     *
     * Initializes the command by loading the current route collection from the Router.
     */
    public function __construct()
    {
        // Get the router instance and load all registered routes
        $this->routes = Router::getInstance()->loadRoutes()->routes;
    }

    /**
     * Define validation rules for command arguments (not used in this command).
     *
     * @return array An empty array as this command doesn't accept arguments
     */
    protected function validator(): array
    {
        return []; 
    }

    /**
     * Execute the console command.
     *
     * Compiles route information into a formatted table and displays it.
     *
     * @return void
     */
    public function handle(): void
    {
        $tableData = [];

        // Process routes for each HTTP method
        foreach (['get', 'post', 'put', 'delete', 'patch'] as $method) {
            if (!empty($this->routes[$method])) {
                foreach ($this->routes[$method] as $uri => $route) {
                    $tableData[] = [
                        'Method'      => strtoupper($method),
                        'URI'         => $uri,
                        'Name'        => $this->findRouteName($this->routes['names'], $uri),
                        'Action'      => $this->formatAction($route),
                        'Middleware'  => $this->formatMiddleware($route['middleware'] ?? []),
                    ];
                }
            }
        }

        // Display the compiled route information as a table
        $this->table($tableData);
    }

    /**
     * Find the name of a route by its URI.
     *
     * @param array $names The route names collection
     * @param string $uri The URI to search for
     * @return string The route name if found, otherwise an empty string
     */
    protected function findRouteName(array $names, string $uri): string
    {
        return array_search($uri, $names) ?: '';
    }

    /**
     * Format the action for display in the table.
     *
     * @param array $route The route information
     * @return string Formatted controller action or 'Closure' for anonymous functions
     */
    protected function formatAction(array $route): string
    {
        if (isset($route['controller']) && isset($route['action'])) {
            return $route['controller'] . '@' . $route['action'];
        }
        return 'Closure';
    }

    /**
     * Format middleware for display in the table.
     *
     * @param array $middleware The middleware stack
     * @return string Comma-separated list of middleware
     */
    protected function formatMiddleware(array $middleware): string
    {
        return implode(', ', $middleware);
    }
}