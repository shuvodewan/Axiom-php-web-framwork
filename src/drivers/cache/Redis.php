<?php

namespace Core\drivers\cache;

use Core\contract\CacheContract;
use Core\traits\CacheTrait;
use Predis\Client; 

class Redis implements CacheContract {

    use CacheTrait;

    private $redis;

    public function __construct() {
       
        $config = config('redis.redis');
        
        $this->redis = new Client([
            'scheme'    => 'tcp',
            'host'      => $config['host'],
            'port'      => $config['port'],
            'database'  => $config['database'],
            'password'  => $config['password'],
            'timeout'   => $config['timeout'],
            'persistent'=> $config['persistent'] ? ['prefix' => 'persistent:'] : []
        ]);
    }

    private function getRedisKey(string $key): string {
        return 'cache:' . md5($key);
    }

    public function get(string $key) {
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

    public function set(string $key, mixed $value, int $ttl = 3600) {
        $data = [
            'expires' => time() + $ttl,
            'value' => $value
        ];

        $redisKey = $this->getRedisKey($key);
        $this->redis->setex($redisKey, $ttl, $this->getSerializeData($data));
    }

    public function delete(string $key) {
        $redisKey = $this->getRedisKey($key);
        $this->redis->del($redisKey);
    }

    public function has(string $key): bool {
        return $this->get($key) !== null;
    }

    public function clear() {
        $keys = $this->redis->keys('cache:*');
        foreach ($keys as $key) {
            $this->redis->del($key);
        }
    }
}