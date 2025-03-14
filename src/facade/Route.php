<?php

namespace Core\facade;

use Core\contract\FacadeContract;
use Core\http\Route as HttpRoute;
use Core\traits\FacadeTrait;

class Route implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return new HttpRoute();
    }
}
