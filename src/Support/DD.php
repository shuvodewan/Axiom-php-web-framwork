<?php
namespace Axiom\Support;

use Symfony\Component\VarDumper\VarDumper;

class DD
{
    public function run($vars){
        VarDumper::dump($vars);
    }
}