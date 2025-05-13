<?php

namespace Axiom\Facade;

use Axiom\Database\DB as DatabaseDB;

/**
 * DB Facade
 *
 * Provides a static interface to the `DatabaseDB` class for encryption and decryption functionality.
 * This facade allows convenient access to cryptographic methods without needing to
 * manually instantiate the `DatabaseDB` class.
 */
class DB implements FacadeContract
{
    use FacadeTrait;

    /**
     * Get the underlying instance of the `DatabaseDB` class.
     *
     * @return DatabaseDB The instance of `DatabaseDB`
     */
    public static function getInstance(): DatabaseDB
    {
        if (!isset(self::$instance)) {
            self::$instance = DatabaseDB::getInstance();
        }

        return self::$instance;
    }
}