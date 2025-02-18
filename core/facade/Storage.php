<?php

namespace Core\facade;

use Core\contract\FacadeContract;
use Core\Storage as CoreStorage;
use Core\traits\FacadeTrait;

class Storage implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return new CoreStorage();
    }
}