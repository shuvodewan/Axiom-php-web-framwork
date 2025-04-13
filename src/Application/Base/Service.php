<?php

namespace Axiom\Application\Base;

use Axiom\Core\ServiceProxy;

class Service
{
    protected $entity;


    public static function initiate() :ServiceProxy
    {
        return new ServiceProxy(static::class);
    }
}