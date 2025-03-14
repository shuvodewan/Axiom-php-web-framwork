<?php

namespace Core\facade;

use Core\contract\FacadeContract;
use Core\http\Request as HttpRequest;
use Core\traits\FacadeTrait;

class Request implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return HttpRequest::getInstance();
    }
}