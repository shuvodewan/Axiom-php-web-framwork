<?php

namespace Axion\Cache;

use Core\Contract\CacheContract;

/**
 * File-based cache driver.
 *
 * This class implements the CacheContract interface and provides a file-based caching mechanism.
 * It stores cache data in files within a specified directory and supports TTL (Time-To-Live) for cache entries.
 */
class FileDriver implements CacheContract
{
    use CacheTrait;

    /** @var string The base directory for cache files. */
    private string $cacheDir;

    /** @var string The subdirectory for cache files (used for organization). */
    private string $subdir = 'default';

    /**
     * Constructor.
     *
     * Initializes the cache directory and ensures it exists.
     */
    public function __construct()
    {
        $this->cacheDir = storage_path('/cache');
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0777, true);
        }
    }

    /**
     * Retrieves a value from the cache.
     *
     * @param string $key The cache key.
     * @return mixed The cached value, or null if the key does not exist or has expired.
     */
    public function get(string $key): mixed
    {
        $file = $this->getFilePath($key);
        if (!file_exists($file)) {
            return null;
        }

        $data = $this->getDeserializeData(file_get_contents($file));
        if ($data['expires'] > time()) {
            return $data['value'];
        }

        unlink($file);
        return null;
    }

    /**
     * Stores a value in the cache.
     *
     * @param string $key The cache key.
     * @param mixed $value The value to store.
     * @param int $ttl The time-to-live in seconds (default: 3600 seconds / 1 hour).
     */
    public function set(string $key, mixed $value, int $ttl = 3600): void
    {
        $data = [
            'expires' => time() + $ttl,
            'value' => $value,
        ];

        $this->ensureSubdirExists();
        if (!file_put_contents($this->getFilePath($key), $this->getSerializeData($data))) {
            throw new \RuntimeException("Failed to write cache file: {$this->getFilePath($key)}");
        }
    }

    /**
     * Deletes a value from the cache.
     *
     * @param string $key The cache key.
     */
    public function delete(string $key): void
    {
        $file = $this->getFilePath($key);
        if (file_exists($file)) {
            unlink($file);
        }
    }

    /**
     * Checks if a key exists in the cache.
     *
     * @param string $key The cache key.
     * @return bool True if the key exists and is not expired, false otherwise.
     */
    public function has(string $key): bool
    {
        return $this->get($key) !== null;
    }

    /**
     * Clears all cache entries.
     */
    public function clear(): void
    {
        array_map('unlink', glob($this->cacheDir . '/' . $this->subdir . '/*.cache'));
    }

    /**
     * Generates the file path for a cache key.
     *
     * @param string $key The cache key.
     * @return string The full file path for the cache entry.
     */
    private function getFilePath(string $key): string
    {
        return $this->cacheDir . '/' . $this->subdir . '/' . md5($key) . '.cache';
    }

    /**
     * Ensures the subdirectory for cache files exists.
     */
    private function ensureSubdirExists(): void
    {
        $subdirPath = $this->cacheDir . '/' . $this->subdir;
        if (!is_dir($subdirPath)) {
            mkdir($subdirPath, 0777, true);
        }
    }
}