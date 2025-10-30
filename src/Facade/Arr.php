<?php

namespace Axiom\Facade;

use Axiom\Support\Arr as SupportArr;

/**
 * Cache Facade
 *
 * Provides a static interface to the `SupportArr` class for caching functionality.
 * This facade allows convenient access to caching methods without needing to
 * manually instantiate the `SupportArr` class.
 */
class Arr implements FacadeContract
{
    use FacadeTrait;

    /**
     * Get the underlying instance of the `SupportArr` class.
     *
     * @return SupportArr The singleton instance of `CacheCache`
     */
    public static function getInstance(): SupportArr
    {
        return new SupportArr();
    }
}