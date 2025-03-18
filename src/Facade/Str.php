<?php

namespace Axiom\Facade;

use Axiom\Support\Str as SupportStr;

/**
 * Str Facade
 *
 * Provides a static interface to the `SupportStr` class for string manipulation utilities.
 * This facade allows convenient access to string-related methods without needing to
 * manually instantiate the `SupportStr` class.
 */
class Str implements FacadeContract
{
    use FacadeTrait;

    /**
     * Get the singleton instance of the `SupportStr` class.
     *
     * If the instance does not exist, it is created. Subsequent calls will return
     * the same instance.
     *
     * @return SupportStr The singleton instance of `SupportStr`
     */
    public static function getInstance(): SupportStr
    {
        if (!isset(self::$instance)) {
            self::$instance = new SupportStr();
        }

        return self::$instance;
    }
}