<?php

namespace Axiom\Facade;

use Axiom\Support\Url as SupportUrl;

/**
 * Str Facade
 *
 * Provides a static interface to the `SupportUrl` class for string manipulation utilities.
 * This facade allows convenient access to string-related methods without needing to
 * manually instantiate the `SupportUrl` class.
 */
class Url implements FacadeContract
{
    use FacadeTrait;

    /**
     * Get the singleton instance of the `SupportUrl` class.
     *
     * If the instance does not exist, it is created. Subsequent calls will return
     * the same instance.
     *
     * @return SupportUrl The singleton instance of `SupportUrl`
     */
    public static function getInstance(): SupportUrl
    {
        if (!isset(self::$instance)) {
            self::$instance = new SupportUrl();
        }

        return self::$instance;
    }
}