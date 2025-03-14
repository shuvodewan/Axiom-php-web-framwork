<?php

namespace Core\facade;

use Core\contract\FacadeContract;
use Core\traits\FacadeTrait;
use Core\util\Str as UtilStr;

class Str implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return  new UtilStr();
    }
}