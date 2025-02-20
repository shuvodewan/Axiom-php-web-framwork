<?php

namespace Core\drivers\cache;

use Core\contract\CacheContract;
use Core\traits\CacheTrait;

class File implements CacheContract {

    use CacheTrait;

    private $cacheDir;
   
    public function __construct() {

        $this->cacheDir = storage_path('/cache');
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0777, true);
        }
    }

    public function get(string $key) {
        $file = $this->getFilePath($key);
        if (!file_exists($file)) return null;

        $data = $this->getDeserializeData(file_get_contents($file));
        if ($data['expires'] > time()) {
            return $data['value'];
        }

        unlink($file);
        return null;
    }

    public function set(string $key, mixed $value, int $ttl = 3600) {
        $data = [
            'expires' => time() + $ttl,
            'value' => $value
        ];

        $this->ensureSubdirExists();

        file_put_contents($this->getFilePath($key), $this->getSerializeData($data));
    }

    public function delete(string $key) {
        $file = $this->getFilePath($key);
        if (file_exists($file)) {
            unlink($file);
        }
    }

    public function has(string $key): bool {
        return $this->get($key) !== null;
    }

    public function clear() {
        array_map('unlink', glob($this->cacheDir . '/*.cache'));
    }

    private function getFilePath(string $key): string {
        return $this->cacheDir . '/' . $this->subdir. '/' . md5($key) . '.cache';
    }

    private function ensureSubdirExists() {
        $subdirPath = $this->cacheDir . '/' . $this->subdir;
        if (!is_dir($subdirPath)) {
            mkdir($subdirPath, 0777, true);
        }
    }
}