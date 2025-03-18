<?php

namespace Axiom\Facade;

use Axiom\Filesystem\FileManager;

/**
 * Storage Facade
 *
 * Provides a static interface to the `FileManager` class for filesystem operations.
 * This facade allows convenient access to filesystem methods without needing to
 * manually instantiate the `FileManager` class.
 */
class Storage implements FacadeContract
{
    use FacadeTrait;

    /**
     * Get the underlying instance of the `FileManager` class.
     *
     * @return FileManager The instance of `FileManager`
     */
    public static function getInstance(): FileManager
    {
        return new FileManager();
    }
}