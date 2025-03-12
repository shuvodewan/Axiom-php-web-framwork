<?php

namespace Core\console\commands;

use Core\console\Command;
use Core\drivers\filesystem\Local;
use Exception;

class CreateApplicationCommand extends Command
{
    protected $apps;
    protected $filesystem;

    public function __construct()
    {
        $this->apps = config('app.applications');
        $this->filesystem = new Local(['root'=>app_path()]);
    }

    protected function validator():array
    {
       return [
        'name'=>'required|max:50'
       ]; 
    }

    
    public function handle(){
       
        $this->start('Creating application');
        try{
            $this->checkUnique()->createAppDir()->generateApplication();
            $this->end('Application created');
        }catch(Exception $e){
            $this->error($e->getMessage());
        }
       
    }


    private function checkUnique(){
        $this->info('Checking application...');
        if(in_array('app.' . $this->argument('name'),$this->apps)){
            throw new Exception($this->argument('name') . 'already exist!');
        }

        return $this;
    }

    private function createAppDir()
    {
        $this->info('Creating application dir...');

        $name = $this->argument('name');

        if (!$this->filesystem->directoryExists($name)) {
            $this->filesystem->createDirectory($name);
        }

        return $this;
    }

    private function generateApplication()
    {
        
        $name = $this->argument('name');

        (new ModelGeneratorCommand())->handle($name,$name);

        return $this;
    }

}
