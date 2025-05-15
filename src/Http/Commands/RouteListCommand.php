<?php

namespace Axiom\Http\Commands;

use Axiom\Console\Command;
use Axiom\Http\Router;

class RouteListCommand extends Command
{
    protected $routes;


    public function __construct()
    {
        $this->routes = Router::getInstance()->loadRoutes()->routes;
    }

    protected function validator():array
    {
       return []; 
    }

    
    public function handle() :void
    {
       
        $tableData = [];

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
        $this->table($tableData);
    }

    protected function findRouteName(array $names, string $uri): string
    {
        return array_search($uri, $names) ?: '';
    }

    protected function formatAction(array $route): string
    {
        if (isset($route['controller']) && isset($route['action'])) {
            return $route['controller'] . '@' . $route['action'];
        }
        return 'Closure';
    }

    protected function formatMiddleware(array $middleware): string
    {
        return implode(', ', $middleware);
    }
}
