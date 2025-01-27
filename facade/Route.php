<?php

namespace Facade;

use Contract\FacadeContract;
use Core\Route as CoreRoute;
use Traits\FacadeTrait;

class Route implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return new CoreRoute();
    }
}