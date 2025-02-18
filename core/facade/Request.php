<?php

namespace Core\facade;

use Core\contract\FacadeContract;
use Core\Request as CoreRequest;
use Core\traits\FacadeTrait;

class Request implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return CoreRequest::getInstance();
    }
}