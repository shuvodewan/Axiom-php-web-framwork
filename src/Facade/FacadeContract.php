<?php

namespace Axiom\Facade;

interface FacadeContract
{
    /**
     * Get the underlying instance that the facade represents.
     *
     * @return mixed
     */
    public static function getInstance();
}