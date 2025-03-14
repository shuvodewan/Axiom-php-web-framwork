<?php

namespace Core\facade;

use Core\contract\FacadeContract;
use Core\traits\FacadeTrait;
use Core\util\Crypt as UtilCrypt;

class Crypt implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return new UtilCrypt();
    }
}