<?php

namespace Axiom\Core\Attribute;

use Attribute;
use Axiom\Core\Enum\RouteEnum;

#[Attribute(Attribute::TARGET_METHOD)]
class Put extends Route 
{
    public function __construct(
        string $uri,
        array $middlewares = [],
        string $name = ''
        ) {
        parent::__construct($uri, $middlewares, $name, RouteEnum::PUT);
    }

    protected function setRoute() :self
    {
        $this->commonSetup()->route->put($this->uri, $this->controller, $this->action);
        return $this;
    }
}