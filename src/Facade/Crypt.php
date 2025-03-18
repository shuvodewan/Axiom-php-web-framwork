<?php

namespace Axiom\Facade;

use Axiom\Support\Crypt as SupportCrypt;

/**
 * Crypt Facade
 *
 * Provides a static interface to the `SupportCrypt` class for encryption and decryption functionality.
 * This facade allows convenient access to cryptographic methods without needing to
 * manually instantiate the `SupportCrypt` class.
 */
class Crypt implements FacadeContract
{
    use FacadeTrait;

    /**
     * Get the underlying instance of the `SupportCrypt` class.
     *
     * @return SupportCrypt The instance of `SupportCrypt`
     */
    public static function getInstance(): SupportCrypt
    {
        if (!isset(self::$instance)) {
            self::$instance = new SupportCrypt();
        }

        return self::$instance;
    }
}