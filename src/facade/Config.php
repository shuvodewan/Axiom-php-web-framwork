<?php

namespace Core\facade;

use Core\contract\FacadeContract;
use Core\support\Config as SupportConfig;
use Core\traits\FacadeTrait;

class Config implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return SupportConfig::getInstance();
    }
}