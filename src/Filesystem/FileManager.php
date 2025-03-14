<?php

namespace Axiom\Filesystem;

use Axiom\Traits\InstanceTrait;
use Exception;

/**
 * Class FileManager
 *
 * Manages filesystem operations across multiple drivers (e.g., local, S3).
 * Provides a unified interface for interacting with different storage systems.
 */
class FileManager
{
    use InstanceTrait;
    /**
     * Registered filesystem drivers.
     *
     * @var array<string, object>
     */
    protected array $drivers = [];

    /**
     * The currently selected disk.
     *
     * @var string
     */
    protected string $disk;

    /**
     * A map of registered driver classes.
     *
     * @var array<string, string>
     */
    protected array $registerDrivers = [
        'local' => LocalDriver::class,
        's3'    => S3Driver::class,
    ];

    /**
     * FileManager constructor.
     *
     * Initializes the FileManager with the specified disk or the default disk from the configuration.
     *
     * @param string|null $disk The disk to use. If null, the default disk from the configuration is used.
     */
    public function __construct(?string $disk = null)
    {
        $this->disk = $disk ?? config('filesystem.default');
        $this->setDriver();
    }

    /**
     * Switch to a different disk.
     *
     * @param string $name The name of the disk to switch to.
     * @return self
     */
    public function disk(string $name): self
    {
        $this->disk = $name;
        return $this->setDriver();
    }

    /**
     * Get the currently selected disk.
     *
     * @return string The name of the currently selected disk.
     */
    public function getDisk(): string
    {
        return $this->disk;
    }

    /**
     * Read the contents of a file.
     *
     * @param string $path The path to the file.
     * @return string The contents of the file.
     */
    public function get(string $path): string
    {
        return $this->setDriver()->read($this->setDiskPath($path));
    }

    /**
     * Write contents to a file.
     *
     * @param string $contents The contents to write.
     * @param string|null $path The path to the file. If null, a temporary path is used.
     * @return bool True on success, false on failure.
     */
    public function put(string $contents, ?string $path = null): bool
    {
        return $this->setDriver()->write($this->setDiskPath($path), $contents);
    }

    /**
     * Delete a file.
     *
     * @param string $path The path to the file.
     * @return void
     */
    public function delete(string $path): void
    {
        $this->setDriver()->delete($path);
    }

    /**
     * Check if a file exists.
     *
     * @param string $path The path to the file.
     * @return bool True if the file exists, false otherwise.
     */
    public function exists(string $path): bool
    {
        return $this->setDriver()->fileExists($path);
    }

    /**
     * Get the URL for a file.
     *
     * @param string $path The path to the file.
     * @return string The URL for the file.
     */
    public function url(string $path): string
    {
        return $this->setDriver()->getUrl($path);
    }


    /**
     * Normalize the file path by trimming slashes.
     *
     * @param string|null $path The path to normalize.
     * @return string The normalized path.
     */
    protected function setDiskPath(?string $path = null): string
    {
        return trim($path ?? '', '/');
    }

    /**
     * Set the current driver based on the selected disk.
     *
     * @return self
     * @throws Exception If the driver is not found.
     */
    protected function setDriver(): self
    {
        $driver = config('filesystem.disks.' . $this->disk . '.driver');

        if (!array_key_exists($driver, $this->registerDrivers)) {
            throw new Exception("Driver '$driver' not found.");
        }

        if (!array_key_exists($driver, $this->drivers)) {
            $this->drivers[$driver] = new $this->registerDrivers[$driver](
                config('filesystem.disks.' . $this->disk)
            );
        }

        return $this->drivers[$driver];
    }
}