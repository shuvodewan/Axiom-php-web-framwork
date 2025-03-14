<?php

namespace Core\facade;

use Core\contract\FacadeContract;
use Core\support\Filesystem as SupportFilesystem;
use Core\traits\FacadeTrait;

class Filesystem implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return new SupportFilesystem();
    }
}