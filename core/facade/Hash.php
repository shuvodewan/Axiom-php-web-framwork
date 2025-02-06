<?php

namespace Core\facade;

use Core\contract\FacadeContract;
use Core\Hash as CoreHash;
use Traits\FacadeTrait;

class Hash implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return new CoreHash();
    }
}