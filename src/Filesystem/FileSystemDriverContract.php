<?php

namespace Axiom\Filesystem;

/**
 * Interface FileSystemDriverContract
 *
 * Defines the contract for a filesystem driver.
 * Any filesystem driver implementation must provide a method to generate a URL for a given file path.
 */
interface FileSystemDriverContract
{
    /**
     * Get the URL for a given file path.
     *
     * This method should return the full URL for the specified file path.
     * The implementation may prepend a base URL or handle the path in a way specific to the filesystem.
     *
     * @param string $path The file path.
     * @return string The full URL for the file.
     */
    public function getUrl(string $path): string;
}