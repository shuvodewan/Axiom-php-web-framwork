<?php

namespace Axiom\Core\Attribute;

use Attribute;
use Axiom\Http\Route;
use Closure;

#[Attribute(Attribute::TARGET_CLASS)]
class Group 
{

    protected Route $route;

    /** @var string The group name. */
    protected ?string $name;

    /** @var array The middleware applied to the group. */
    protected array $middlewares = [];

    /** @var string The group prefix. */
    protected ?string $prefix=null;

    public function __construct(array $middlewares = [], ?string $prefix =null, ?string $name = null) {

        $this->middlewares = $middlewares;
        $this->name = $name;
        $this->prefix = $prefix;
        $this->route  =   new Route();
    }


    public function getParams(): array
    {
        $params=[];

        if(!empty($this->middlewares)){
            $params['middlewares'] = $this->middlewares;
        }

        if(!empty($this->name)){
            $params['name'] = $this->name;
        }

        if(!empty($this->prefix)){
            $params['prefix'] = $this->prefix;
        }

        return $params;

    }

    public function setGroup(Closure $func) :self
    {
        $this->route->group($this->getParams(), $func);

        return $this;
    }

    
}