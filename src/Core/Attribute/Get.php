<?php

namespace Axiom\Core\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Get extends Route 
{

    protected function setRoute() :self
    {
        $this->commonSetup()->route->get($this->uri, $this->controller, $this->action);
        return $this;
    }
}