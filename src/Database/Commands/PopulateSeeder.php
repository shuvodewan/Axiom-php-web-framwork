<?php

namespace Axiom\Database\Commands;

use Axiom\Console\Command;
use Database\Seeders\DatabaseSeeder;

class PopulateSeeder extends Command
{
    protected $filesystem;

    protected function validator():array
    {
       return []; 
    }

    
    public function handle() :void
    {
        (new DatabaseSeeder())->run();
    }
}
