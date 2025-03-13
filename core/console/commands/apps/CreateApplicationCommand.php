<?php

namespace Core\console\commands\apps;

use Core\application\App;
use Core\console\Command;
use Core\drivers\filesystem\Local;
use Exception;

class CreateApplicationCommand extends Command
{
    protected $app;
    protected $filesystem;

    public function __construct()
    {
        $this->app = new App();
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
            $this->checkUnique()->createAppDir()->deleteExisting()->generateApplication();
            $this->end('Application created');
        }catch(Exception $e){
            $this->error($e->getMessage());
        }
       
    }


    private function checkUnique(){
        $this->info('Checking application...');
        if($this->app->isRegistered($this->argument('name'))){
            throw new Exception($this->argument('name') . ' already exist!');
        }

        return $this;
    }

    private function deleteExisting(){
        $this->info('Deleting unregistered existing application...');
        $name = $this->argument('name');
        if ($this->filesystem->directoryExists($name)) {
            try{  
                $this->filesystem->deleteDirectory($name);
                $this->info("Application '$name' successfully deleted.");
            } catch(Exception $e) {
                throw new Exception($e->getmessage());
            }
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
