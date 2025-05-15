<?php
namespace Axiom\Support;

use Axiom\Console\Preview;
use Axiom\Core\Application;
use Symfony\Component\VarDumper\VarDumper;

class DD
{
    public function run($vars){
        VarDumper::dump($vars);
    }
}