<?php

namespace Axiom\Http;

use Axiom\Database\Entity;
use Axiom\Database\Paginator;

abstract class Transformar
{
    private $data;
    private $additionals;

    public function __construct($data, $additionals)
    {
        $this->checkDataType($data);
        $this->data = $data;
        $this->additionals = $additionals;
    }

    abstract public function resource();

    abstract public function resources();

    protected function paginate()
    {
        return [
            'meta' => $this->data->meta(),
            'links' => $this->data->links(),
        ];
    }

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

    protected function getType($data = null)
    {
        $data = $data??$this->data;

        $type = null;

        if($this->data instanceof Entity || is_object($this->data)){
           'object';
        }

        if(is_array($this->data) || $this->data  instanceof \Traversable){
            $type = 'traversable';
        }

        if($data  instanceof Paginator){
            $type = 'paginate';
        }

        return $type;
    }

    protected function processData()
    {
        $type = $this->getType();

        if($type->object)
    }


    protected function processObject()
    {
        
    }

    protected function processTraversable()
    {

    }

    protected function processPaginate()
    {

    }

    public function value()
    {
        return $this->processData();
    }

    public function __call($method, $args)
    {
        if (str_starts_with($method, 'get')) {
            $method = lcfirst(substr($method, 3));
    
            if (!method_exists($this, $method)) {
                throw new \BadMethodCallException("Method '{$method}' does not exist.");
            }
    
            
        }
    
        throw new \BadMethodCallException("Method '{$method}' does not exist.");
    }

    // new UserTransformer($users)->getResource()
}