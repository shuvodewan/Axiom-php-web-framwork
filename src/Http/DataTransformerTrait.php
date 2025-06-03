<?php

namespace Axiom\Http;

use Axiom\Database\Entity;
use ReflectionProperty;

/**
 * Trait for transforming data from various sources into consistent structures
 * 
 * Provides property access functionality for:
 * - Arrays
 * - Entity objects
 * - Generic objects (with both public and private properties)
 */
trait DataTransformerTrait
{
    /**
     * Get a property value from the current resource
     * 
     * Handles different resource types:
     * 1. Arrays: returns array value if key exists
     * 2. Entity objects: calls getter method or property directly
     * 3. Regular objects: returns public properties only
     * 
     * @param string $key The property/key to retrieve
     * @return mixed|null The property value or null if not found/accessible
     * 
     */
    protected function getProperty(string $key)
    {
        if (is_array($this->resource)) {
            return $this->resource[$key] ?? null;
        }

        if ($this->resource instanceof Entity) {
            return $this->getEntityProperty($key);
        }

        if (is_object($this->resource)) {
            return $this->getObjectProperty($key);
        }

        return null;
    }

    /**
     * Get property from an Entity object
     * 
     * @param string $key Property name to retrieve
     * @return mixed|null
     */
    private function getEntityProperty(string $key)
    {
        $method = method_exists($this->resource, $key) ? $key : 'get' . ucfirst($key);
        return $this->resource->$method();
    }

    /**
     * Get property from a generic object
     * 
     * @param string $key Property name to retrieve
     * @return mixed|null
     */
    private function getObjectProperty(string $key)
    {
        if (!property_exists($this->resource, $key)) {
            return null;
        }

        try {
            $reflection = new ReflectionProperty($this->resource, $key);
            if ($reflection->isPublic()) {
                return $this->resource->$key;
            }
        } catch (\ReflectionException $e) {
            return null;
        }

        return null;
    }
}