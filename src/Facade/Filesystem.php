<?php

namespace Axiom\Facade;

use Axiom\Filesystem\Filesystem as FilesystemFilesystem;

/**
 * Str Facade
 *
 * Provides a static interface to the `FilesystemFilesystem` class for string manipulation utilities.
 * This facade allows convenient access to string-related methods without needing to
 * manually instantiate the `FilesystemFilesystem` class.
 */
class Filesystem implements FacadeContract
{
    use FacadeTrait;

    /**
     * Get the singleton instance of the `FilesystemFilesystem` class.
     *
     * If the instance does not exist, it is created. Subsequent calls will return
     * the same instance.
     *
     * @return FilesystemFilesystem The singleton instance of `FilesystemFilesystem`
     */
    public static function getInstance(): FilesystemFilesystem
    {
        if (!isset(self::$instance)) {
            self::$instance = new FilesystemFilesystem();
        }

        return self::$instance;
    }
}