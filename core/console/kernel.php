<?php

namespace Core\console;

class Kernel
{
    protected $commands = [];

    public function __construct()
    {

        $this->commands = [
            
        ];
    }

    public function handle(array $argv)
    {
        if (count($argv) < 2) {
            $this->showHelp();
            return;
        }

        $command = $argv[1];
        if (isset($this->commands[$command])) {
            $commandClass = $this->commands[$command];
            $commandInstance = new $commandClass();
            $commandInstance->run(array_slice($argv, 2));
        } else {
            echo "Command not found: $command\n";
        }
    }

    protected function showHelp()
    {
        echo "Available commands:\n";
        foreach ($this->commands as $command => $class) {
            echo " - $command\n";
        }
    }
}