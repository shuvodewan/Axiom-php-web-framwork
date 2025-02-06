<?php

namespace Core\facade;

use Core\contract\FacadeContract;
use Core\Crypt as CoreCrypt;
use Traits\FacadeTrait;

class Crypt implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return new CoreCrypt();
    }
}