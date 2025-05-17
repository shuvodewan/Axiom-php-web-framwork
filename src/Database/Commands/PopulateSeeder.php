<?php

namespace Axiom\Database\Commands;

use Axiom\Application\AppManager;
use Axiom\Console\Command;
use Axiom\Filesystem\LocalDriver;
use Database\Seeders\DatabaseSeeder;

class PopulateSeeder extends Command
{
    protected $filesystem;

    protected function validator():array
    {
       return [
        'class'=>'nullable|string'
       ]; 
    }


    private function getSeeders(){
        $appSeeders = AppManager::getInstance()->getSeeders();
        $databaseSeeders = (new LocalDriver(['root' => database_path()]))->listContents('Seeders');
        dd($databaseSeeders);
    }

    
    public function handle() :void
    {

        if($class = $this->argument('class')){
            $this->getSeeders();
        }

        (new DatabaseSeeder())->run();
    }
}
