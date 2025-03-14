<?php

namespace Core\support;

abstract class Serializer
{
    protected $resource;

    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    abstract protected function serialize($item):array;

    public function toArray()
    {
        if(is_array($this->resource)){
            return array_map(fn($item)=>$this->serialize($item),$this->resource);
        }
        return $this->serialize($this->resource);
    }

    // Convert data to JSON
    public function toJson()
    {
        return json_encode($this->toArray());
    }

}