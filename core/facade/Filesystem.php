<?php

namespace Core\facade;

use Core\contract\FacadeContract;
use Core\Filesystem as CoreFilesystem;
use Core\traits\FacadeTrait;

class Filesystem implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return new CoreFilesystem();
    }
}