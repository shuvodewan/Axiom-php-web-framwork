<?php

namespace Axion\Cache;

use Axiom\Support\Str;
use Axiom\Traits\InstanceTrait;
use Exception;

/**
 * Cache manager class.
 *
 * This class provides a unified interface for interacting with different cache drivers.
 * It dynamically loads the configured cache driver and delegates method calls to it.
 */
class Cache
{
    use InstanceTrait;

    /** @var array A map of supported cache drivers and their corresponding classes. */
    protected array $drivers = [
        'file' => FileDriver::class,
        'redis' => RedisDriver::class,
    ];

    /** @var CacheContract The cache driver instance. */
    protected $driver;

    /**
     * Constructor.
     *
     * Initializes the cache manager with the default driver specified in the configuration.
     */
    public function __construct()
    {
        $this->setDriver(config('cache.default'));
        self::setInstance($this);
    }

    /**
     * Sets the cache driver.
     *
     * @param string $driver The name of the cache driver to use.
     * @throws Exception If the driver cannot be initialized.
     */
    public function setDriver(string $driver): void
    {
        try {
            $driver = (new Str())->toLower($driver);

            // Check if the driver is supported
            if (!isset($this->drivers[$driver])) {
                throw new Exception("Cache driver '{$driver}' is not supported.");
            }

            $className = $this->drivers[$driver];
            if (!class_exists($className)) {
                throw new Exception("Cache driver class '{$className}' does not exist.");
            }

            $this->driver = new $className();
        } catch (Exception $exception) {
            throw new Exception("Cannot initialize cache driver '{$driver}': " . $exception->getMessage());
        }
    }

    /**
     * Delegates method calls to the cache driver.
     *
     * @param string $method The method name.
     * @param array $arguments The method arguments.
     * @return mixed The result of the method call.
     * @throws Exception If the method does not exist on the cache driver.
     */
    public function __call(string $method, array $arguments)
    {
        if (!method_exists($this->driver, $method)) {
            throw new Exception("Method '{$method}' does not exist on the cache driver.");
        }

        return $this->driver->$method(...$arguments);
    }
}