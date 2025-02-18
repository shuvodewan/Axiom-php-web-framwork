<?php

namespace Core\facade;

use Core\contract\FacadeContract;
use Core\Str as CoreStr;
use Core\traits\FacadeTrait;

class Str implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return  new CoreStr();
    }
}