<?php

namespace App\Test\Controllers;

use Axiom\Core\Attribute\Get;

class TestController 
{
    #[Get(uri:'/', name:'index')]
    public function index(){
       
    }
}