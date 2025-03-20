<?php

namespace Axiom\Filesystem;

use League\Flysystem\Filesystem;
use League\Flysystem\StorageAttributes;
use League\Flysystem\Local\LocalFilesystemAdapter;

/**
 * Class LocalDriver
 *
 * Implements a local filesystem driver using Flysystem.
 * This driver allows interaction with the local filesystem and provides URL generation for stored files.
 */
class LocalDriver extends Filesystem implements FileSystemDriverContract
{
    /**
     * Configuration options for the local filesystem driver.
     *
     * @var array
     */
    protected array $config = [];

    /**
     * LocalDriver constructor.
     *
     * Initializes the local filesystem driver with the provided configuration.
     *
     * @param array $config Configuration options for the driver.
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        parent::__construct(new LocalFilesystemAdapter($config['root']));
    }

    /**
     * Get the URL for a given file path.
     *
     * If a base URL is configured, it prepends the base URL to the file path.
     * The base URL must be a valid HTTP URL.
     * Otherwise, it returns the file path as-is.
     *
     * @param string $path The file path.
     * @return string The full URL or file path.
     */
    public function getUrl(string $path): string
    {
        if (isset($this->config['url'])) {
            return rtrim($this->config['url'], '/') . '/' . ltrim($path, '/');
        }

        return $path;
    }

    /**
     * Get all files from a directory.
     *
     * @param string $directory The directory path.
     * @param bool $recursive Whether to list files recursively.
     * @return array An array of file paths.
     */
    public function getFiles(string $directory, bool $recursive = false): array
    {
        $files = [];
        $contents = $this->listContents($directory, $recursive);
        foreach ($contents as $item) {
            if ($item instanceof StorageAttributes && $item->isFile()) {
                $files[] = $item->path();
            }
        }

        return $files;
    }
}