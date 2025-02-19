<?php

namespace Core\facade;

use Core\Cache as CoreCache;
use Core\contract\FacadeContract;
use Core\traits\FacadeTrait;

class Cache implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return CoreCache::getInstance();
    }
}