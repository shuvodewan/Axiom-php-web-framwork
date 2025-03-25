<?php

namespace Axiom\Application;

class App 
{
    public string $controllers = "Controllers";
    public string $entities = 'Entities';
    public ?string $group=null;
    public bool   $appRoute=false;
    public array  $middlewares=[];
}