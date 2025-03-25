<?php

namespace Axiom\Core\Attribute;

use Attribute;
use Axiom\Core\Enum\RouteEnum;

#[Attribute(Attribute::TARGET_METHOD)]
class Patch extends Route 
{
    public function __construct(
        string $uri,
        array $middlewares = [],
        string $name = ''
        ) {
        parent::__construct($uri, $middlewares, $name, RouteEnum::PATCH);
    }

    protected function setRoute() :self
    {
        $this->commonSetup()->route->patch($this->uri, $this->controller, $this->action);
        return $this;
    }
}