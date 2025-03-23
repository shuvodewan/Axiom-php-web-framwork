<?php

namespace Axiom\Core\Attribute;

use Attribute;
use Axiom\Core\Enum\RouteEnum;
use Axiom\Http\Route as HttpRoute;

#[Attribute(Attribute::TARGET_METHOD)]
class Route
{
    protected HttpRoute $route;
    protected string $method;
    protected string $controller;
    protected string $action;

    /** @var string The route name. */
    protected ?string $name;

    /** @var array The middleware applied to the route. */
    protected array $middlewares = [];

    /** @var string The route URI. */
    protected string $uri = '';


    public function __construct(
        string $uri,
        array $middlewares = [],
        ?string $name = null, 
        RouteEnum $method = RouteEnum::GET
        ) {
        $this->uri          =   $uri;
        $this->middlewares  =   $middlewares;
        $this->name         =   $name;
        $this->route        =   new HttpRoute();
        $this->method       =   $method->value;
    }


    public function register($controller, $action)
    {
        $this->controller = $controller;
        $this->action = $action;
        $this->setRoute();
    }

    protected function setRoute() :self
    {
        $method = $this->method;

        $this->route->$method($this->uri, $this->controller, $this->action);

        if(!empty($this->middlewares)){
            $this->route->middlewares($this->middlewares);
        }
        return $this;
    }
}