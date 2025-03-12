<?php

namespace Core\console;

use Core\console\commands\AppCashClearCommand;
use Core\console\commands\AppServeCommand;
use Core\console\commands\CreateApplicationCommand;
use Core\facade\Cache;
use Core\facade\Log;
use Exception;

class Kernel
{
    protected $commands = [];

    public function __construct()
    {

        $this->commands = [
            'project-cache:clear'=>AppCashClearCommand::class,
            'project-start'=>AppServeCommand::class,
            'app-create'=>CreateApplicationCommand::class,
        ];
    }

    public function handle(array $argv)
    {
        try{
            if (count($argv) < 2) {
                $this->showHelp();
                return;
            }

            $this->runCommand($argv);
        }catch(Exception $e){
            Log::error($e->getMessage(),[
                'trace'=> $e->getTraceAsString()
            ]);
            
            return Preview::render($e->getMessage());
        }

        
    }

    protected function runCommand(array $argv){
        $command = $argv[1];
        if (isset($this->commands[$command])) {
            $class = $this->commands[$command];
            (new $class())->setArguments(array_slice($argv, 2))->handle();
        } else {
            throw new Exception("Command {$command} not found");
        }
    }

    protected function showHelp()
    {
        Preview::render('Available commands: ', 'white');
        foreach ($this->commands as $command => $class) {
            Preview::render($command);
        }
    }


    private function handleConsoleExceptionResponse($e){
        Preview::render($e->getMessage(), 'bright_red');       
    }

}