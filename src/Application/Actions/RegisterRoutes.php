<?php

namespace Axiom\Application\Actions;

use Axiom\Filesystem\LocalDriver;

class RegisterRoutes
{
    public function load(array $controllerDirs): void
    {
        $driver = new LocalDriver(['root'=>'/']);
        $controllers = [];
        foreach($controllerDirs as $dir){
            foreach($driver->getFiles($dir,true) as $file){
                array_push($controllers, $file);
            }
        }
      
        $this->registerRoute($controllers);
    }


    public function registerRoute(array $files): void
    {
        dd(new $files[0]());
    }
}