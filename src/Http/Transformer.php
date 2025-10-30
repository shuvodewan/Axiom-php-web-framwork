<?php

namespace Axiom\Http;

use Axiom\Database\Entity;
use Axiom\Database\Paginator;

/**
 * Abstract base transformer for converting data structures into API resources
 * 
 * This class provides the foundation for transforming various data types (entities, 
 * arrays, collections, paginated results) into structured API responses.
 */
abstract class Transformer
{
    use DataTransformerTrait;

    /** @var mixed The input data to be transformed */
    private $data;
    
    /** @var mixed Additional data that can be used during transformation */
    private $additionals;
    
    /** @var string The method to call for transforming a single resource */
    protected $sourceMethod = 'resource';
    
    /** @var mixed The current resource being transformed */
    protected $resource = null;

    /**
     * Transformer constructor
     *
     * @param mixed $data The data to transform (Entity, array, Traversable, or Paginator)
     * @param mixed $additionals Additional context data for the transformation
     * 
     * @throws \InvalidArgumentException If data type is not supported
     */
    public function __construct($data, $additionals = null)
    {
        $this->checkDataType($data);
        $this->data = $data;
        $this->additionals = $additionals;
    }

    /**
     * Transform a single resource into an array
     * 
     * @return array The transformed resource data
     * 
     * @example
     * [
     *     'id' => 123,
     *     'name' => 'John Doe',
     *     'email' => 'john@example.com',
     *     // ... other fields
     * ]
     */
    abstract public function resource(): array;

    /**
     * Transform a collection of resources (alternative format)
     * 
     * @return array The transformed collection data
     * 
     * @example
     * [
     *     'count' => 2,
     *     'items' => [
     *         ['id' => 1, 'name' => 'Item 1'],
     *         ['id' => 2, 'name' => 'Item 2']
     *     ]
     * ]
     */
    abstract public function resources(): array;

    /**
     * Get pagination metadata from a Paginator instance
     * 
     * @return array Pagination metadata structure
     * 
     * @example
     * [
     *     'meta' => [
     *         'total' => 100,
     *         'per_page' => 15,
     *         'current_page' => 1,
     *         'last_page' => 7
     *     ],
     *     'links' => [
     *         'first' => '/items?page=1',
     *         'last' => '/items?page=7',
     *         'prev' => null,
     *         'next' => '/items?page=2'
     *     ]
     * ]
     */
    protected function paginate()
    {
        return [
            'meta' => $this->data->meta(),
            'links' => $this->data->links(),
        ];
    }

    /**
     * Determine the type of data being transformed
     * 
     * @param mixed $data Data to check (uses instance data if null)
     * @return string One of: 'paginate', 'object', or 'traversable'
     * 
     * @throws \InvalidArgumentException If data type is not supported
     */
    protected function getType($data = null): string
    {
        $data = $data ?? $this->data;
        
        if ($data instanceof Paginator) {
            return 'paginate';
        }
        
        if ($data instanceof Entity || is_object($data)) {
            return 'object';
        }
        
        if (is_array($data) || $data instanceof \Traversable) {
            return 'traversable';
        }
        
        throw new \InvalidArgumentException('Unsupported data type. Expected Entity, array, Traversable, or Paginator.');
    }

    /**
     * Validate that the input data is of a supported type
     * 
     * @param mixed $data Data to validate
     * @throws \InvalidArgumentException If data type is not supported
     */
    protected function checkDataType($data)
    {
        if (
            !($data instanceof Entity) &&
            !is_array($data) &&
            !($data instanceof \Traversable) &&
            !is_object($data)
        ) {
            throw new \InvalidArgumentException(
                'Data must be an instance of Entity, an array, php object, or an iterable.'
            );
        }
    }

    /**
     * Process the input data according to its type
     * 
     * @return mixed The transformed data structure
     * 
     * @throws \RuntimeException If data type cannot be processed
     */
    protected function processData()
    {
        $type = $this->getType();

        switch ($type) {
            case 'object':
                return $this->processObject();
            case 'traversable':
                return $this->processTraversable();
            case 'paginate':
                return $this->processPaginate();
            default:
                throw new \RuntimeException("Unprocessable data type: {$type}");
        }
    }

    /**
     * Process a single object resource
     * 
     * @return array The transformed resource
     */
    protected function processObject()
    {
        $this->resource = $this->data;
        return $this->{$this->sourceMethod}();
    }

    /**
     * Process a traversable collection of resources
     * 
     * @return array Array of transformed resources
     */
    protected function processTraversable()
    {
        $items = [];
        foreach ($this->data as $resource) {
            $this->resource = $resource;
            $items[] = $this->{$this->sourceMethod}();
        }

        return $items;
    }

    /**
     * Process paginated data
     * 
     * @return array Structured paginated response
     * 
     * @example
     * [
     *     'items' => [...transformed items...],
     *     'meta' => [...pagination meta...],
     *     'links' => [...pagination links...]
     * ]
     */
    protected function processPaginate()
    {
        $items = [];
        foreach ($this->data as $resource) {
            $this->resource = $resource;
            $items[] = $this->{$this->sourceMethod}();
        }
        return [
            'items' => $items,
            'meta' => $this->data->meta(),
            'links' => $this->data->links(),
        ];
    }

    /**
     * Get the transformed value
     * 
     * @return mixed The final transformed data structure
     */
    public function value()
    {
        return $this->processData();
    }

    /**
     * Magic getter for accessing resource properties
     * 
     * @param string $key Property name to access
     * @return mixed The property value if found
     */
    public function __get(string $key)
    {
        if (property_exists($this, $key) && in_array($key, get_object_vars($this))) {
            return $this->$key;
        }

        return $this->getProperty($key);
    }

    /**
     * Magic call method for dynamic method handling
     * 
     * @param string $method Method being called
     * @param array $args Method arguments
     * @return $this|mixed
     * 
     * @throws \BadMethodCallException If method doesn't exist
     */
    public function __call($method, $args)
    {
        if (str_starts_with($method, 'get')) {
            $method = lcfirst(substr($method, 3));
    
            if (!method_exists($this, $method)) {
                throw new \BadMethodCallException("Method '{$method}' does not exist.");
            }
            
            $this->sourceMethod = $method;
            return $this;
        }
    
        throw new \BadMethodCallException("Method '{$method}' does not exist.");
    }
}