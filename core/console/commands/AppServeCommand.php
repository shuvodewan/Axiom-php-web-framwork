<?php

namespace Core\console\commands;

use Core\console\Command;

class AppServeCommand extends Command
{
    protected function validator():array
    {
       return[
        'host'=>'required',
        'port'=>'required'
       ]; 
    }
    public function handle(){
        $this->start('Starting server');
        $command = "php -S" . $this->argument('host') . ":" . $this->argument('port') . " -t public";
        echo "Server running at http://" . $this->argument('host') . ":" . $this->argument('port') . "\n";
        exec($command);

        $this->end('server started');
    }
}
