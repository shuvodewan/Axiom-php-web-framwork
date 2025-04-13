<?php

namespace Axiom\Core;

use Axiom\Traits\InstanceTrait;
use DI\Container as DIContainer;
use DI\ContainerBuilder;
use DI\DependencyException;
use DI\NotFoundException;
use Closure;

/**
 * Dependency Injection Container wrapper for PHP-DI.
 * 
 * Provides a configured DI container instance with autowiring and attribute support.
 * Implements singleton pattern via InstanceTrait for easy global access.
 * 
 * Features:
 * - Autowiring support
 * - PHP 8 attribute support
 * - Production compilation caching
 * - Singleton access pattern
 * - Type-safe dependency resolution
 * - Full container interface implementation
 */
class Container
{
    use InstanceTrait;

    protected ContainerBuilder $builder;
    protected ?DIContainer $container = null;

    public function __construct()
    {
        $this->builder = new ContainerBuilder();
        $this->builder->useAutowiring(true);
        $this->builder->useAttributes(true);

        if (config('app.mode') === 'prod') {
            $cachePath = storage_path('/cache/container');
            $this->ensureCacheDirectoryExists($cachePath);
            $this->builder->enableCompilation($cachePath);
        }

        $this->container = $this->builder->build();
        self::setInstance($this);
    }

    /**
     * Set a value or factory in the container.
     *
     * @param string $id Entry identifier
     * @param mixed $value Value or factory closure
     */
    public function set(string $id, $value): void
    {
        $this->container->set($id, $value);
    }

    /**
     * Get an entry from the container.
     *
     * @template T
     * @param string|class-string<T> $id Entry identifier
     * @return T
     * @throws NotFoundException
     * @throws DependencyException
     */
    public function get(string $id)
    {
        return $this->container->get($id);
    }

    /**
     * Check if the container has an entry for the given identifier.
     *
     * @param string $id Entry identifier
     * @return bool
     */
    public function has(string $id): bool
    {
        return $this->container->has($id);
    }

    /**
     * Call the given function and inject its dependencies.
     *
     * @param callable $callable Function to call
     * @param array $parameters Additional parameters
     * @return mixed
     * @throws NotFoundException
     * @throws DependencyException
     */
    public function call($callable, array $parameters = [])
    {
        return $this->container->call($callable, $parameters);
    }

    /**
     * Define an object or a value in the container.
     *
     * @param string $name Entry name
     * @param mixed|Closure $value Value or factory closure
     */
    public function define(string $name, $value): void
    {
        $this->set($name, $value);
    }

    /**
     * Make a new instance of a class with dependencies injected.
     *
     * @template T
     * @param class-string<T> $class Class name
     * @param array $parameters Additional parameters
     * @return T
     * @throws NotFoundException
     * @throws DependencyException
     */
    public function make(string $class, array $parameters = [])
    {
        return $this->container->make($class, $parameters);
    }

    /**
     * Register a service provider.
     *
     * @param string $provider Class name of service provider
     */
    public function register(string $provider): void
    {
        $providerInstance = $this->make($provider);
        $providerInstance->register($this);
    }

    /**
     * Get all entries bound to the container.
     *
     * @return array
     */
    public function getEntries(): array
    {
        return $this->container->getKnownEntryNames();
    }

    /**
     * Flush the container, removing all resolved instances.
     */
    public function flush(): void
    {
        $this->container = $this->builder->build();
    }

    protected function ensureCacheDirectoryExists(string $path): void
    {
        if (!file_exists($path)) {
            mkdir($path, 0755, true) or throw new \RuntimeException("Failed to create cache directory: {$path}");
        }
        is_writable($path) or throw new \RuntimeException("Cache directory not writable: {$path}");
    }
}