<?php

namespace Core\facade;

use Core\contract\FacadeContract;
use Core\support\Cache as SupportCache;
use Core\traits\FacadeTrait;

class Cache implements FacadeContract
{
    use FacadeTrait;
    
    public static function getInstance(){
        return SupportCache::getInstance();
    }
}