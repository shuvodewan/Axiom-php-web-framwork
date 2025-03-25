<?php

namespace Axiom\Application\Actions;

use Axiom\Core\Attribute\Delete;
use Axiom\Core\Attribute\Get;
use Axiom\Core\Attribute\Group;
use Axiom\Core\Attribute\Patch;
use Axiom\Core\Attribute\Post;
use Axiom\Core\Attribute\Put;
use Axiom\Core\Attribute\Route;
use Axiom\Filesystem\LocalDriver;
use Axiom\Http\Route as HttpRoute;
use Axiom\Http\Router;
use Axiom\Project\Registry;
use Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionAttribute;
use RuntimeException;

/**
 * Handles automatic route registration by scanning controller files
 * and processing their routing attributes.
 */
class RegisterRoutes
{
    /**
     * Loads and registers routes from all application controllers.
     *
     * @param array<object{dir: string, group?: string, appRoute?: bool, name: string, middlewares?: array}> $apps
     * @throws RuntimeException If route registration fails
     */
    public function load(array $apps): void
    {
        $driver = new LocalDriver(['root' => '/']);
        $controllers = [];

        foreach ($apps as $app) {
            foreach ($driver->getFiles($app->dir, true) as $file) {
                $controllers[] = [
                    'file' => $file,
                    'app' => $app
                ];
            }
        }
        $this->registerRoute($controllers);
        
    }

    /**
     * Registers routes from discovered controller files.
     *
     * @param array<array{file: string, app: object}> $controllers
     */
    public function registerRoute(array $controllers): void
    {
        foreach ($controllers as $controller) {
            $content = file_get_contents('/' . $controller['file']);
            $className = $this->getClassFromFile(htmlspecialchars($content));
            if ($className) {
                $reflection = new ReflectionClass($className);
                $this->generateRoute($reflection, $className,$controller);
            }
        }
    }

    /**
     * Generates routes for a controller with proper grouping.
     *
     * @param ReflectionClass $reflection The controller class reflection
     * @param string $className Fully qualified class name
     * @param array{file: string, app: object} $controller Controller metadata
     */
    protected function generateRoute(ReflectionClass $reflection, string $className, array $controller): void
    {
        if ($controller['app']->group && !empty(Registry::$GROUPS[$controller['app']->group])) {
            (new HttpRoute())->group(
                Registry::$GROUPS[$controller['app']->group],
                function() use($reflection, $className, $controller) {
                    $this->registerWithApp($reflection, $className, $controller);
                }
            );
        } else {
            $this->registerWithApp($reflection, $className, $controller);
        }
    }

    /**
     * Registers routes within application-specific route group if configured.
     *
     * @param ReflectionClass $reflection The controller class reflection
     * @param string $className Fully qualified class name
     * @param array{file: string, app: object} $controller Controller metadata
     */
    protected function registerWithApp(ReflectionClass $reflection, string $className, array $controller): void
    {
        if ($controller['app']->appRoute) {
            $group = [
                'name' => $controller['app']->name . '.',
                'prefix' => $controller['app']->name,
                'middlewares' => $controller['app']->middlewares ?? []
            ];

            (new HttpRoute())->group($group, function() use($reflection, $className) {
                $this->compileRoute($reflection, $className);
            });
        } else {
            $this->compileRoute($reflection, $className); 
        }
    }

    /**
     * Compiles routes with optional controller-level grouping.
     *
     * @param ReflectionClass $reflection The controller class reflection
     * @param string $className Fully qualified class name
     */
    protected function compileRoute(ReflectionClass $reflection, string $className): void
    {
        $groupAttribute = $this->groupAttribute($reflection);
        if ($groupAttribute !== null) {
            $groupAttribute->newInstance()->setGroup(function() use($reflection, $className) {
                $this->processRoutes($reflection, $className);
            });
        } else {
            $this->processRoutes($reflection, $className);
        }
    }

    /**
     * Processes all route attributes on controller methods.
     *
     * @param ReflectionClass $reflection The controller class reflection
     * @param string $className Fully qualified class name
     */
    protected function processRoutes(ReflectionClass $reflection, string $className): void
    {
        foreach ($reflection->getMethods() as $method) {
            $attributes = [];

            $this->getRouteAttribute($method, $attributes)
                 ->postRouteAttribute($method, $attributes)
                 ->putRouteAttribute($method, $attributes)
                 ->patchRouteAttribute($method, $attributes)
                 ->deleteRouteAttribute($method, $attributes);

            foreach ($attributes as $attribute) {
                $attribute->newInstance()->register($className, $method->getName());
            }
        }
    }

    /**
     * Extracts fully qualified class name from file content.
     *
     * @param string $content PHP file content
     * @return string|null Fully qualified class name or null if not found
     */
    protected function getClassFromFile(string $content): ?string
    {
        $namespacePattern = '/namespace\s+([^\s;]+);/';
        preg_match($namespacePattern, $content, $namespaceMatches);
        $namespace = $namespaceMatches[1] ?? '';

        $classPattern = '/class\s+([^\s{]+)/';
        preg_match($classPattern, $content, $classMatches);
        $className = $classMatches[1] ?? '';

        return ($namespace && $className) ? $namespace . '\\' . $className : null;
    }

    /**
     * Collects GET route attributes from method.
     *
     * @param ReflectionMethod $action Method reflection
     * @param array<ReflectionAttribute> $attributes Reference to attributes array
     * @return self
     */
    protected function getRouteAttribute(ReflectionMethod $action, array &$attributes): self
    {
        $attributes = array_merge($attributes, $action->getAttributes(Get::class));
        return $this;
    }

    /**
     * Collects POST route attributes from method.
     *
     * @param ReflectionMethod $action Method reflection
     * @param array<ReflectionAttribute> $attributes Reference to attributes array
     * @return self
     */
    protected function postRouteAttribute(ReflectionMethod $action, array &$attributes): self
    {
        $attributes = array_merge($attributes, $action->getAttributes(Post::class));
        return $this;
    }

    /**
     * Collects PUT route attributes from method.
     *
     * @param ReflectionMethod $action Method reflection
     * @param array<ReflectionAttribute> $attributes Reference to attributes array
     * @return self
     */
    protected function putRouteAttribute(ReflectionMethod $action, array &$attributes): self
    {
        $attributes = array_merge($attributes, $action->getAttributes(Put::class));
        return $this;
    }

    /**
     * Collects PATCH route attributes from method.
     *
     * @param ReflectionMethod $action Method reflection
     * @param array<ReflectionAttribute> $attributes Reference to attributes array
     * @return self
     */
    protected function patchRouteAttribute(ReflectionMethod $action, array &$attributes): self
    {
        $attributes = array_merge($attributes, $action->getAttributes(Patch::class));
        return $this;
    }

    /**
     * Collects DELETE route attributes from method.
     *
     * @param ReflectionMethod $action Method reflection
     * @param array<ReflectionAttribute> $attributes Reference to attributes array
     * @return self
     */
    protected function deleteRouteAttribute(ReflectionMethod $action, array &$attributes): self
    {
        $attributes = array_merge($attributes, $action->getAttributes(Delete::class));
        return $this;
    }

    /**
     * Gets Group attribute from class if present.
     *
     * @param ReflectionClass $class Class reflection
     * @return ReflectionAttribute|null Group attribute or null if not found
     */
    protected function groupAttribute(ReflectionClass $class): ?ReflectionAttribute
    {
        $items = $class->getAttributes(Group::class);
        return $items[0] ?? null;
    }
}