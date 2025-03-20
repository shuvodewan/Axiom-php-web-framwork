<?php

namespace Axiom\Core\Attribute;

use Attribute;
use Axiom\Core\Enum\RouteEnum;
use Axiom\Http\Route as HttpRoute;

#[Attribute]
class Route
{
    protected $route;
    protected $method;
    protected $controller;
    protected $action;

    /** @var string The route name. */
    protected string $name = '';

    /** @var array The middleware applied to the route. */
    protected array $middlewares = [];

    /** @var string The route URI. */
    protected string $uri = '';


    public function __construct(
        string $uri,
        array $middlewares = [],
        string $name = '', 
        RouteEnum $method = RouteEnum::GET
        ) {
        $this->uri          =   $uri;
        $this->middlewares  =   $middlewares;
        $this->name         =   $name;
        $this->route        =   new HttpRoute();
        $this->method       =   $method->value;
    }
}