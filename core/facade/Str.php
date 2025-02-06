<?php

namespace Core\facade;

use Contract\FacadeContract;
use Core\Str as CoreStr;
use Traits\FacadeTrait;

class Str implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return  new CoreStr();
    }
}