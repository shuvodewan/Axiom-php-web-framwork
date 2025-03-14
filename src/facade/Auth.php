<?php

namespace Core\facade;

use Core\contract\FacadeContract;
use Core\support\Auth as SupportAuth;
use Core\traits\FacadeTrait;

class Auth implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return new SupportAuth();
    }
}