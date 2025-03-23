<?php

namespace Axiom\Core\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Get extends Route 
{

    protected function setRoute() :self
    {
        $this->route->get($this->uri, $this->controller, $this->action);

        if(!empty($this->middlewares)){
            $this->route->middlewares($this->middlewares);
        }
        return $this;
    }
}