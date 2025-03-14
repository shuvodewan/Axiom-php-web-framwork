<?php

namespace Core\facade;

use Core\contract\FacadeContract;
use Core\support\Log as SupportLog;
use Core\traits\FacadeTrait;

class Log implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return SupportLog::getInstance();
    }
}