<?php

namespace Axiom\Core\Attribute;

use Attribute;
use Axiom\Core\Enum\RouteEnum;

#[Attribute]
class Post extends Route 
{
    public function __construct(
        string $uri,
        array $middlewares = [],
        string $name = ''
        ) {
        parent::__construct($uri, $middlewares, $name, RouteEnum::POST);
    }
}