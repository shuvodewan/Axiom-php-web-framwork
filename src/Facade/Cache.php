<?php

namespace Axiom\Facade;

use Axion\Cache\Cache as CacheCache;

/**
 * Cache Facade
 *
 * Provides a static interface to the `CacheCache` class for caching functionality.
 * This facade allows convenient access to caching methods without needing to
 * manually instantiate the `CacheCache` class.
 */
class Cache implements FacadeContract
{
    use FacadeTrait;

    /**
     * Get the underlying instance of the `CacheCache` class.
     *
     * @return CacheCache The singleton instance of `CacheCache`
     */
    public static function getInstance(): CacheCache
    {
        return CacheCache::getInstance();
    }
}