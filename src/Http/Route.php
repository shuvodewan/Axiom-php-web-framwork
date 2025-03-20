<?php

namespace Axiom\Http;

/**
 * Route management class.
 *
 * This class provides methods to define routes, set middleware, prefixes, and names,
 * and register routes with the router.
 */
class Route
{
    /** @var Router The router instance. */
    protected Router $router;

    /** @var string The route prefix. */
    protected string $prefix = '';

    /** @var string The route name. */
    public string $name = '';

    /** @var array The middleware applied to the route. */
    public array $middlewares = [];

    /** @var string The route URI. */
    public string $uri = '';

    /** @var string The controller associated with the route. */
    public string $controller = '';

    /** @var string|null The action (method) associated with the route. */
    public ?string $action = null;

    /**
     * Constructor.
     *
     * Initializes the route with the router instance.
     */
    public function __construct()
    {
        $this->router = Router::getInstance();
    }

    /**
     * Sets middleware for the route.
     *
     * @param array|string $middlewares The middleware(s) to apply.
     * @return self
     */
    public function middlewares($middlewares): self
    {
        is_array($middlewares) ? $this->setMiddlewares($middlewares) : $this->setSingleMiddleware($middlewares);
        return $this;
    }

    /**
     * Sets a prefix for the route.
     *
     * @param string $prefix The prefix to apply.
     * @return self
     */
    public function prefix(string $prefix): self
    {
        $this->prefix = trim($prefix, '/');
        return $this;
    }

    /**
     * Sets a name for the route.
     *
     * @param string $name The name to apply.
     * @return self
     */
    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Gets the name of the method that called the current route method.
     *
     * @return string The method name.
     */
    private function getMethodName(): string
    {
        return debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3)[2]['function'];
    }

    /**
     * Defines a route group.
     *
     * @param array|callable $params The group parameters or a callable function.
     * @param callable|null $func The callable function for the group.
     */
    public function group($params = [], $func = null): void
    {
        $parent = $this->setGroupParent();

        if (is_callable($params)) {
            $params();
            return;
        }

        if (is_array($params)) {
            $this->router->setGroupData($params);
        }

        if (is_callable($func)) {
            call_user_func($func);
        }

        $this->cleanGroupData($parent);
    }

    /**
     * Registers a GET route.
     *
     * @param string $uri The route URI.
     * @param string $controller The controller associated with the route.
     * @param string|null $action The action (method) associated with the route.
     */
    public function get(string $uri, string $controller, ?string $action = null): void
    {
        $this->registerRoutes($uri, $controller, $action);
    }

    /**
     * Registers a POST route.
     *
     * @param string $uri The route URI.
     * @param string $controller The controller associated with the route.
     * @param string|null $action The action (method) associated with the route.
     */
    public function post(string $uri, string $controller, ?string $action = null): void
    {
        $this->registerRoutes($uri, $controller, $action);
    }

    /**
     * Registers a PUT route.
     *
     * @param string $uri The route URI.
     * @param string $controller The controller associated with the route.
     * @param string|null $action The action (method) associated with the route.
     */
    public function put(string $uri, string $controller, ?string $action = null): void
    {
        $this->registerRoutes($uri, $controller, $action);
    }

    /**
     * Registers a DELETE route.
     *
     * @param string $uri The route URI.
     * @param string $controller The controller associated with the route.
     * @param string|null $action The action (method) associated with the route.
     */
    public function delete(string $uri, string $controller, ?string $action = null): void
    {
        $this->registerRoutes($uri, $controller, $action);
    }

    /**
     * Registers a PATCH route.
     *
     * @param string $uri The route URI.
     * @param string $controller The controller associated with the route.
     * @param string|null $action The action (method) associated with the route.
     */
    public function patch(string $uri, string $controller, ?string $action = null): void
    {
        $this->registerRoutes($uri, $controller, $action);
    }

    /**
     * Sets a single middleware for the route.
     *
     * @param string $middleware The middleware to apply.
     */
    private function setSingleMiddleware(string $middleware): void
    {
        if (!is_array($middleware)) {
            array_push($this->middlewares, $middleware);
        }
    }

    /**
     * Sets multiple middlewares for the route.
     *
     * @param array $middlewares The middlewares to apply.
     */
    private function setMiddlewares(array $middlewares): void
    {
        foreach ($middlewares as $middleware) {
            $this->setSingleMiddleware($middleware);
        }
    }

    /**
     * Registers a route with the router.
     *
     * @param string $uri The route URI.
     * @param string $controller The controller associated with the route.
     * @param string|null $action The action (method) associated with the route.
     */
    private function registerRoutes(string $uri, string $controller, ?string $action = null): void
    {
        $this->uri = $this->setUri($uri);
        $this->controller = $controller;
        $this->action = $action;

        $this->router->registerRoutes($this->getMethodName(), $this);
    }

    /**
     * Sets the full URI for the route, including the prefix.
     *
     * @param string $uri The route URI.
     * @return string The full URI.
     */
    private function setUri(string $uri): string
    {
        return $this->prefix ? $this->prefix . '/' . $uri : $uri;
    }

    /**
     * Sets the group parent flag.
     *
     * @return bool True if the group parent flag was set, false otherwise.
     */
    private function setGroupParent(): bool
    {
        if (!$this->router->groupParent) {
            $this->router->groupParent = true;
            return true;
        }
        return false;
    }

    /**
     * Cleans up group data after a group is processed.
     *
     * @param bool $isParent Whether the current group is a parent group.
     */
    private function cleanGroupData(bool $isParent): void
    {
        if ($isParent) {
            $this->router->cleanData();
        }
    }
}