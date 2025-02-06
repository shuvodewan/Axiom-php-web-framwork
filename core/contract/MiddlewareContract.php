<?php

namespace Contract;

interface MiddlewareContract
{
    static function handle($request,$next);
}