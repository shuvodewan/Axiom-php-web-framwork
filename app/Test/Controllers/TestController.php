<?php

namespace App\Test\Controllers;

use Axiom\Core\Attribute\Get;

class TestController 
{
    #[Get('/')]   
    #[Get('/index')]
    public function index(){

    }
}