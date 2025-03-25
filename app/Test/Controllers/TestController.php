<?php

namespace App\Test\Controllers;

use Axiom\Core\Attribute\Get;
use Axiom\Core\Attribute\Group;

#[Group(prefix:'test',name:'test.',middlewares:['web'])]
class TestController 
{
    #[Get(uri:'index',middlewares:['auth'], name:'index')]
    public function index(){
        dd('sdf');
    }
}