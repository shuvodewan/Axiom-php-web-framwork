<?php

namespace Core\console\commands\apps;

use Core\console\Command;
use Core\drivers\filesystem\Local;
use Exception;

class DeleteApplicationCommand extends Command
{
    protected $filesystem;

    public function __construct()
    {
        $this->filesystem = new Local(['root'=>app_path()]);
    }

    protected function validator():array
    {
       return [
        'name'=>'required|max:50'
       ]; 
    }

    
    public function handle(){
       
        $this->start('Deleting application');
        try{
            $this->deleteAppDir();
            $this->end('Application Deleted');
        }catch(Exception $e){
            $this->error($e->getMessage());
        }
       
    }


    private function deleteAppDir()
    {
        $this->info('deleting application dir...');

        $name = $this->argument('name');

        if (!$this->filesystem->directoryExists($name)) {
            throw new Exception("Application '$name' does not exist.");
        }

        try{  
            $this->filesystem->deleteDirectory($name);
            $this->info("Application '$name' successfully deleted.");
        } catch(Exception $e) {
            throw new Exception($e->getmessage());
        }

        return $this;
    }

}
