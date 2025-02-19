<?php

namespace Core\facade;

use Core\contract\FacadeContract;
use Core\Router as CoreRouter;
use Core\traits\FacadeTrait;

class Router implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return CoreRouter::getInstance();
    }
}
