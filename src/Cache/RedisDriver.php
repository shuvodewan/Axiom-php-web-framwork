<?php

namespace Axion\Cache;

use Predis\Client;

/**
 * Redis-based cache driver.
 *
 * This class implements the CacheContract interface and provides a Redis-based caching mechanism.
 * It stores cache data in Redis and supports TTL (Time-To-Live) for cache entries.
 */
class RedisDriver implements CacheContract
{
    use CacheTrait;

    /** @var Client The Redis client instance. */
    private Client $redis;

    /**
     * Constructor.
     *
     * Initializes the Redis client using configuration settings.
     */
    public function __construct()
    {
        $config = config('redis.redis');

        $this->redis = new Client([
            'scheme'    => 'tcp',
            'host'      => $config['host'],
            'port'      => $config['port'],
            'database'  => $config['database'],
            'password'  => $config['password'],
            'timeout'   => $config['timeout'],
            'persistent' => $config['persistent'] ? ['prefix' => 'persistent:'] : []
        ]);
    }

    /**
     * Generates a Redis key for the given cache key.
     *
     * @param string $key The cache key.
     * @return string The Redis key.
     */
    private function getRedisKey(string $key): string
    {
        return 'cache:' . md5($key);
    }

    /**
     * Retrieves a value from the cache.
     *
     * @param string $key The cache key.
     * @return mixed The cached value, or null if the key does not exist or has expired.
     */
    public function get(string $key): mixed
    {
        $redisKey = $this->getRedisKey($key);
        $data = $this->redis->get($redisKey);

        if ($data === null) {
            return null;
        }

        $data = $this->getDeserializeData($data);
        if ($data['expires'] > time()) {
            return $data['value'];
        }

        $this->delete($key);
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

        $redisKey = $this->getRedisKey($key);
        $this->redis->setex($redisKey, $ttl, $this->getSerializeData($data));
    }

    /**
     * Deletes a value from the cache.
     *
     * @param string $key The cache key.
     */
    public function delete(string $key): void
    {
        $redisKey = $this->getRedisKey($key);
        $this->redis->del($redisKey);
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
        $keys = $this->redis->keys('cache:*');
        foreach ($keys as $key) {
            $this->redis->del($key);
        }
    }
}