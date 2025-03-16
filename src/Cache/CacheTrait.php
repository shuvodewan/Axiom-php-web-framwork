<?php

namespace Axion\Cache;

use Exception;

/**
 * Trait for handling cache serialization and deserialization.
 *
 * This trait provides methods for setting the serialization format and subdirectory,
 * as well as serializing and deserializing cache data.
 */
trait CacheTrait
{
    /** @var array Allowed serialization formats. */
    private array $allowedFormat = ['json', 'serialize'];

    /** @var string The current serialization format (default: 'json'). */
    private string $format = 'json';

    /** @var string The subdirectory for cache files (default: 'data'). */
    private string $subdir = 'data';

    /**
     * Sets the serialization format.
     *
     * @param string $format The format to use (must be one of: 'json', 'serialize').
     * @return self
     * @throws Exception If the format is not allowed.
     */
    public function setFormat(string $format): self
    {
        if (in_array($format, $this->allowedFormat)) {
            $this->format = $format;
            return $this;
        }

        throw new Exception('Format not allowed');
    }

    /**
     * Sets the subdirectory for cache files.
     *
     * @param string $dir The subdirectory name.
     * @return self
     */
    public function setSubDir(string $dir): self
    {
        $this->subdir = $dir;
        return $this;
    }

    /**
     * Serializes data based on the current format.
     *
     * @param mixed $data The data to serialize.
     * @return string The serialized data.
     */
    private function getSerializeData(mixed $data): string
    {
        return $this->format === 'json' ? json_encode($data) : serialize($data);
    }

    /**
     * Deserializes data based on the current format.
     *
     * @param string $data The serialized data.
     * @return mixed The deserialized data.
     */
    private function getDeserializeData(string $data): mixed
    {
        return $this->format === 'json' ? json_decode($data, true) : unserialize($data);
    }
}