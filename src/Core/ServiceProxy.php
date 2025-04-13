<?php

namespace Axiom\Core;

use Axiom\Core\Container;
use Closure;

class ServiceProxy
{
    /**
     * The container instance
     * @var Container
     */
    protected $container;

    /**
     * The original service class name
     * @var string
     */
    protected $serviceClass;

    /**
     * The original service instance
     * @var object|null
     */
    protected $serviceInstance;

    /**
     * Array of method interceptors
     * @var array
     */
    protected $interceptors = [];

    /**
     * Create a new service proxy
     *
     * @param string $serviceClass
     */
    public function __construct(string $serviceClass)
    {
        $this->serviceClass = $serviceClass;
        $this->container = Container::getInstance();
    }

    /**
     * Proxy method calls to the original service
     *
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $method, array $arguments)
    {
        // Lazy-load the service instance
        if ($this->serviceInstance === null) {
            $this->serviceInstance = $this->container->get($this->serviceClass);
        }

        // Execute before interceptors
        $this->executeBeforeInterceptors($method, $arguments);

        try {
            // Call the original method
            $result = $this->container->call(
                [$this->serviceInstance, $method],
                $arguments
            );

            // Execute after interceptors
            $this->executeAfterInterceptors($method, $arguments, $result);
            return $result;
        } catch (\Throwable $e) {
            // Execute error interceptors if defined
            if (isset($this->interceptors['error'])) {
                $this->executeErrorInterceptors($method, $arguments, $e);
            }
            throw $e;
        }
    }

    /**
     * Add a before interceptor
     *
     * @param string $method
     * @param Closure $callback
     * @return self
     */
    public function before(string $method, Closure $callback): self
    {
        $this->interceptors['before'][$method][] = $callback;
        return $this;
    }

    /**
     * Add an after interceptor
     *
     * @param string $method
     * @param Closure $callback
     * @return self
     */
    public function after(string $method, Closure $callback): self
    {
        $this->interceptors['after'][$method][] = $callback;
        return $this;
    }

    /**
     * Add an error interceptor
     *
     * @param string $method
     * @param Closure $callback
     * @return self
     */
    public function error(string $method, Closure $callback): self
    {
        $this->interceptors['error'][$method][] = $callback;
        return $this;
    }

    /**
     * Execute before interceptors
     *
     * @param string $method
     * @param array $arguments
     */
    protected function executeBeforeInterceptors(string $method, array $arguments): void
    {
        // Global before interceptors (for all methods)
        $globalBefore = $this->interceptors['before']['*'] ?? [];
        
        // Method-specific before interceptors
        $methodBefore = $this->interceptors['before'][$method] ?? [];
        
        foreach (array_merge($globalBefore, $methodBefore) as $interceptor) {
            $interceptor($method, $arguments);
        }
    }

    /**
     * Execute after interceptors
     *
     * @param string $method
     * @param array $arguments
     * @param mixed $result
     */
    protected function executeAfterInterceptors(string $method, array $arguments, $result): void
    {
        // Global after interceptors (for all methods)
        $globalAfter = $this->interceptors['after']['*'] ?? [];
        
        // Method-specific after interceptors
        $methodAfter = $this->interceptors['after'][$method] ?? [];
        
        foreach (array_merge($globalAfter, $methodAfter) as $interceptor) {
            $interceptor($method, $arguments, $result);
        }
    }

    /**
     * Execute error interceptors
     *
     * @param string $method
     * @param array $arguments
     * @param \Throwable $exception
     */
    protected function executeErrorInterceptors(string $method, array $arguments, \Throwable $exception): void
    {
        $globalError = $this->interceptors['error']['*'] ?? [];
        $methodError = $this->interceptors['error'][$method] ?? [];
        
        foreach (array_merge($globalError, $methodError) as $interceptor) {
            $interceptor($method, $arguments, $exception);
        }
    }
}