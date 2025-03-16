<?php

namespace Axion\Cache;

/**
 * Interface for cache drivers.
 *
 * This interface defines the contract for cache implementations, ensuring consistency
 * across different caching mechanisms (e.g., file-based, Redis, etc.).
 */
interface CacheContract
{
    /**
     * Retrieves a value from the cache.
     *
     * @param string $key The cache key.
     * @return mixed The cached value, or null if the key does not exist or has expired.
     */
    public function get(string $key): mixed;

    /**
     * Stores a value in the cache.
     *
     * @param string $key The cache key.
     * @param mixed $value The value to store.
     * @param int $ttl The time-to-live in seconds (default: 3600 seconds / 1 hour).
     */
    public function set(string $key, mixed $value, int $ttl = 3600): void;

    /**
     * Deletes a value from the cache.
     *
     * @param string $key The cache key.
     */
    public function delete(string $key): void;

    /**
     * Checks if a key exists in the cache.
     *
     * @param string $key The cache key.
     * @return bool True if the key exists and is not expired, false otherwise.
     */
    public function has(string $key): bool;

    /**
     * Clears all cache entries.
     */
    public function clear(): void;
}