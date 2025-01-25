<?php

namespace Facade;

use Contract\FacadeContract;
use Core\Response as CoreResponse;
use Traits\FacadeTrait;

class Response implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return CoreResponse::getInstance();
    }
}