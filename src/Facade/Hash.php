<?php

namespace Axiom\Facade;

use Axiom\Support\Hash as SupportHash;

/**
 * Hash Facade
 *
 * Provides a static interface to the `SupportHash` class for hashing functionality.
 * This facade allows convenient access to hashing methods without needing to
 * manually instantiate the `SupportHash` class.
 */
class Hash implements FacadeContract
{
    use FacadeTrait;

    /**
     * Get the underlying instance of the `SupportHash` class.
     *
     * @return SupportHash The instance of `SupportHash`
     */
    public static function getInstance(): SupportHash
    {
        if (!isset(self::$instance)) {
            self::$instance = new SupportHash();
        }

        return self::$instance;
    }
}