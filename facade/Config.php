<?php

namespace Facade;

use Contract\FacadeContract;
use Core\Config as CoreConfig;
use Traits\FacadeTrait;

class Config implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return CoreConfig::getInstance();
    }
}