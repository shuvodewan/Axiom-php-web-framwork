<?php

namespace Core\facade;

use Core\contract\FacadeContract;
use Core\Response as CoreResponse;
use Core\traits\FacadeTrait;

class Response implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return CoreResponse::getInstance();
    }
}