<?php

namespace Core\facade;

use Core\contract\FacadeContract;
use Core\traits\FacadeTrait;
use Core\util\Hash as UtilHash;

class Hash implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return new UtilHash();
    }
}