<?php

namespace Core\facade;

use Core\contract\FacadeContract;
use Core\Route as CoreRoute;
use Traits\FacadeTrait;

class Route implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return CoreRoute::getInstance();
    }
}
