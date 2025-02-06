<?php

namespace Core\facade;

use Contract\FacadeContract;
use Core\Request as CoreRequest;
use Traits\FacadeTrait;

class Request implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return CoreRequest::getInstance();
    }
}