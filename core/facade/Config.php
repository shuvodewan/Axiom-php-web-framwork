<?php

namespace Core\facade;

use Core\contract\FacadeContract;
use Core\Config as CoreConfig;
use Core\traits\FacadeTrait;

class Config implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return CoreConfig::getInstance();
    }
}