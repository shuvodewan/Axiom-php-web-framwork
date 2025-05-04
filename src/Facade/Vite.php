<?php

namespace Axiom\Facade;

use Axiom\Support\Vite as SupportVite;

/**
 * Str Facade
 *
 * Provides a static interface to the `SupportVite` class for string manipulation utilities.
 * This facade allows convenient access to string-related methods without needing to
 * manually instantiate the `SupportStr` class.
 */
class Vite implements FacadeContract
{
    use FacadeTrait;

    /**
     * Get the singleton instance of the `SupportVite` class.
     *
     * If the instance does not exist, it is created. Subsequent calls will return
     * the same instance.
     *
     * @return SupportStr The singleton instance of `SupportVite`
     */
    public static function getInstance(): SupportVite
    {
        if (!isset(self::$instance)) {
            self::$instance = new SupportVite();
        }

        return self::$instance;
    }
}