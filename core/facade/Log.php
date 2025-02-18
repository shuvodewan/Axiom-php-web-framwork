<?php

namespace Core\facade;

use Core\contract\FacadeContract;
use Core\Log as CoreLog;
use Core\traits\FacadeTrait;

class Log implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return CoreLog::getInstance();
    }
}