<?php

namespace Axiom\Http;

use Axiom\Application\AppManager;
use Axiom\Traits\InstanceTrait;
use Exception;
use Axiom\Project\Middlewares\Register;
use Axion\Cache\Cache;

/**
 * Router class.
 *
 * This class handles routing for the application, including route registration,
 * middleware application, and request dispatching.
 */
class Router
{
    use InstanceTrait;

    /** @var array Middlewares applied to routes. */
    protected array $middlewares = [];

    /** @var array Prefixes applied to routes. */
    protected array $prefixes = [];

    /** @var array Names applied to routes. */
    protected array $names = [];

    /** @var Request The current request. */
    public Request $request;

    /** @var bool Whether the current route is part of a group. */
    public bool $groupParent = false;

    /** @var array Registered routes. */
    public array $routes = [
        'get' => [],
        'post' => [],
        'put' => [],
        'delete' => [],
        'patch' => [],
        'names' => [],
    ];

    /**
     * Constructor.
     *
     * @param Request $request The current request.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        self::setInstance($this);
    }


    public function loadRoutes(): self
    {
        if (config('app.route_load') === 'app') {
            return $this->loadFromApp();
        }

        return $this->loadFromRoutes();
    }

    /**
     * get routes path by name.
     *
     * @return string
     */
    public function getNameRoute(string $name, array $params=[])
    {
        $routePath = $this->routes['names'][$name] ?? null;
    
        if ($routePath === null) {
            throw new Exception("Route [{$name}] not defined.");
        }

        $usedKeys = [];
        $path = preg_replace_callback('/\{(\w+)\}/', function ($matches) use ($params, &$usedKeys) {
            $key = $matches[1];
            if (!array_key_exists($key, $params)) {
                return $matches[0]; // Leave unmatched for now
            }
            $usedKeys[] = $key;
            return $params[$key];
        }, $routePath);
    
        // Check for missing parameters and include their names in the error
        if (preg_match_all('/\{(\w+)\}/', $path, $missingMatches)) {
            $missingParams = implode(', ', $missingMatches[1]);
            throw new Exception("Missing parameters [{$missingParams}] for route [{$name}].");
        }
    
        $query = http_build_query(array_diff_key($params, array_flip($usedKeys)));
        if ($query !== '') {
            $path .= '?' . $query;
        }

        return $path;
    }

    /**
     * Loads routes from cache or files.
     *
     * @return self
     */
    public function loadFromRoutes(): self
    {
        if (config('app.mode') === 'production' && !config('app.route_closure')) {
            if ($routes = $this->loadFromCache()) {
                $this->routes = $routes;
            } else {
                $this->loadFromFile()->setRoutesInCache();
            }
        } else {
            $this->loadFromFile();
        }

        return $this;
    }

    public function loadFromApp(): self
    {
        AppManager::getInstance()->registerRoute();
        return $this;
    }

    /**
     * Loads routes from cache.
     *
     * @return array|null The cached routes, or null if not found.
     */
    private function loadFromCache(): ?array
    {
        return (new Cache())->setFormat('serialize')->setSubDir('service')->get('routes');
    }

    /**
     * Stores routes in cache.
     *
     * @return bool True if the routes were successfully cached, false otherwise.
     */
    private function setRoutesInCache(): bool
    {
        return (new Cache())->setFormat('serialize')->setSubDir('service')->set('routes', $this->routes);
    }

    /**
     * Loads routes from route files.
     *
     * @return self
     */
    private function loadFromFile(): self
    {
        $files = $this->loadRouteFiles();
        foreach ($files as $file) {
            include route_path('/' . $file);
        }

        return $this;
    }

    /**
     * Scans the routes directory for route files.
     *
     * @return array The list of route files.
     */
    private function loadRouteFiles(): array
    {
        $files = scandir(route_path());
        return array_diff($files, ['.', '..']);
    }

    /**
     * Registers a route with the router.
     *
     * @param string $method The HTTP method (e.g., 'get', 'post').
     * @param Route $route The route to register.
     * @throws Exception If the route is already defined.
     */
    public function registerRoutes(string $method, Route $route): void
    {
        $uri = trim($route->uri, '/');
        $uri = count($this->prefixes) ? trim(implode('/', $this->prefixes), '/') .( $uri? "/{$uri}":'') : $uri;

        if (isset($route->uri, $this->routes[$method][$uri])) {

            throw new Exception($route->uri . ' Route already defined');
        }

        $params = [
            'controller' => $route->controller,
            'action' => $route->action,
            'middleware' => [...$this->middlewares, ...$route->middlewares],
        ];

        $name = count($this->names) ? implode('', $this->names) . '' . $route->name : $route->name;
        $this->routes[$method][$uri] = $params;
        if ($name) {
            $this->routes['names'][$name] = $uri;
        }
    }

    /**
     * Sets group data (middleware, prefix, name) for route groups.
     *
     * @param array $params The group parameters.
     */
    public function setGroupData(array $params): void
    {
        if (isset($params['middlewares'])) {
            $this->setMiddlewares($params['middlewares']);
        }

        if (isset($params['prefix'])) {
            $this->setPrefix($params['prefix']);
        }

        if (isset($params['name'])) {
            $this->setName($params['name']);
        }
    }

    /**
     * Cleans up group data after a group is processed.
     */
    public function cleanData(): void
    {
        $this->middlewares = [];
        $this->prefixes = [];
        $this->names = [];
    }

    /**
     * Dispatches the request to the appropriate route.
     *
     * @return mixed The response from the route.
     * @throws Exception If the route is not found.
     */
    public function dispatch()
    {
        foreach ($this->routes[Request::getInstance()->method] as $path => $action) {
            $pattern = preg_replace('/\{([^\/]+)\}/', '([^\/]+)', $path);
            if (preg_match("#^$pattern$#", $this->request->uri === '/' ? '' : $this->request->uri, $matches)) {
                array_shift($matches);
                return $this->handleAction($action, $matches);
            }
        }

        throw new Exception($this->request->uri . ' route not found', 404);
    }

    /**
     * Sets middleware for the route group.
     *
     * @param array|string $middlewares The middleware(s) to apply.
     */
    private function setMiddlewares($middlewares): void
    {
        if (!is_array($middlewares)) {
            $this->setSingleMiddleware($middlewares);
        } else {
            foreach ($middlewares as $middleware) {
                $this->setSingleMiddleware($middleware);
            }
        }
    }

    /**
     * Sets a prefix for the route group.
     *
     * @param string $prefix The prefix to apply.
     */
    private function setPrefix(string $prefix): void
    {
        array_push($this->prefixes, trim($prefix, '/'));
    }

    /**
     * Sets a name for the route group.
     *
     * @param string $name The name to apply.
     */
    private function setName(string $name): void
    {
        array_push($this->names, $name);
    }

    /**
     * Sets a single middleware for the route group.
     *
     * @param string $middleware The middleware to apply.
     */
    private function setSingleMiddleware(string $middleware): void
    {
        array_push($this->middlewares, $middleware);
    }

    /**
     * Retrieves registered middleware instances.
     *
     * @param array $middlewares The middleware aliases.
     * @return array The middleware instances.
     */
    private function getRegisterMiddlewares(array $middlewares): array
    {
        $middlewaresStack = [];
        foreach ($middlewares as $middleware) {
            if ($middleware = Register::getMiddleware($middleware)) {
                is_array($middleware) ? array_push($middlewaresStack, ...$middleware) : array_push($middlewaresStack, $middleware);
            }
        }
        return array_reverse($middlewaresStack);
    }

    /**
     * Handles the action for a matched route.
     *
     * @param array $action The route action.
     * @param array $params The route parameters.
     * @return mixed The response from the route.
     */
    private function handleAction(array $action, array $params = [])
    {
        $next = array_reduce($this->getRegisterMiddlewares($action['middleware']), function ($next, $middleware) {
            return function ($request) use ($middleware, $next) {
                return (new ($middleware))->handle($request, $next);
            };
        }, function ($request) use ($action, $params) {
            if (is_callable($action['controller'])) {
                $this->executeAction($request, $action['controller'], $params);
            } else {
                $this->executeControllerAction($request, $action['controller'], $action['action'], $params);
            }
        });

        return $next($this->request);
    }

    /**
     * Executes a controller action.
     *
     * @param Request $request The current request.
     * @param string $controller The controller class.
     * @param string|null $action The controller method.
     * @param array $params The route parameters.
     */
    private function executeControllerAction(Request $request, string $controller, ?string $action = null, array $params = []): void
    {
        $action ? (new $controller())->$action($request, ...$params) : (new $controller())();
    }

    /**
     * Executes a callable action.
     *
     * @param Request $request The current request.
     * @param callable $action The callable action.
     * @param array $params The route parameters.
     */
    private function executeAction(Request $request, callable $action, array $params = []): void
    {
        call_user_func($action, [$request, ...$params]);
    }
}
