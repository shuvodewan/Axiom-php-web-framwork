<?php

namespace Facade;

use Contract\FacadeContract;
use Core\Auth as CoreAuth;
use Traits\FacadeTrait;

class Auth implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return new CoreAuth();
    }
}