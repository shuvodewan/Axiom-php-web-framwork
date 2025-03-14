<?php

namespace Core\console\commands;

use Core\console\Command;

class AppServeCommand extends Command
{
    protected function validator():array
    {
       return []; 
    }

    
    public function handle(){

        $host = $this->argument('host')??'localhost';
        $port = $this->argument('port')??8008;

        $this->start('Starting server');
        $command = "php -S" . $host . ":" . $port . " -t public";
        echo "Server running at http://" . $this->argument('host') . ":" . $this->argument('port') . "\n";
        exec($command);

        $this->end('server started');
    }
}
