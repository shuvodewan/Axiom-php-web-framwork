<?php

namespace Axiom\Facade;

use Axiom\Support\Faker as SupportFaker;

/**
 * Crypt Facade
 *
 * Provides a static interface to the `SupportFaker` class for encryption and decryption functionality.
 * This facade allows convenient access to cryptographic methods without needing to
 * manually instantiate the `SupportFaker` class.
 */
class Faker implements FacadeContract
{
    use FacadeTrait;

    /**
     * Get the underlying instance of the `SupportFaker` class.
     *
     * @return SupportFaker The instance of `SupportFaker`
     */
    public static function getInstance(): SupportFaker
    {
        self::$instance = new SupportFaker();

        return self::$instance;
    }
}