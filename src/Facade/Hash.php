<?php

namespace Axiom\Facade;

use Core\Util\Hash as UtilHash;

/**
 * Hash Facade
 *
 * Provides a static interface to the `UtilHash` class for hashing functionality.
 * This facade allows convenient access to hashing methods without needing to
 * manually instantiate the `UtilHash` class.
 */
class Hash implements FacadeContract
{
    use FacadeTrait;

    /**
     * Get the underlying instance of the `UtilHash` class.
     *
     * @return UtilHash The instance of `UtilHash`
     */
    public static function getInstance(): UtilHash
    {
        if (!isset(self::$instance)) {
            self::$instance = new UtilHash();
        }

        return self::$instance;
    }
}