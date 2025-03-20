<?php

namespace Axiom\Core\Attribute;

use Attribute;
use Axiom\Core\Enum\RouteEnum;

#[Attribute]
class Put extends Route 
{
    public function __construct(
        string $uri,
        array $middlewares = [],
        string $name = ''
        ) {
        parent::__construct($uri, $middlewares, $name, RouteEnum::PUT);
    }
}