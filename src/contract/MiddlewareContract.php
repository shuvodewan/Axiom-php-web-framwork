<?php

namespace Core\contract;

interface MiddlewareContract
{
    static function handle($request,$next);
}