<?php

namespace Core\contract;

interface CacheContract {
    
    public function get(string $key);

    public function set(string $key, mixed $value, int $ttl = 3600);

    public function delete(string $key);

    public function has(string $key): bool;

    public function clear();
}