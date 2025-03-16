<?php

namespace Axiom\Facade;

use Core\contract\FacadeContract;
use Core\http\Response as HttpResponse;
use Core\traits\FacadeTrait;

class Response implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return HttpResponse::getInstance();
    }
}