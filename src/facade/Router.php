<?php

namespace Core\facade;

use Core\contract\FacadeContract;
use Core\http\Router as HttpRouter;
use Core\traits\FacadeTrait;

class Router implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return HttpRouter::getInstance();
    }
}
