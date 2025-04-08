<?php

namespace Axiom\Console;

use Axiom\Application\Commands\CreateApplicationCommand;
use Axiom\Application\Commands\DeleteApplicationCommand;
use Axiom\Application\Commands\EntityHelpCommand;
use Axiom\Console\Commands\AppCashClearCommand;
use Axiom\Console\Commands\AppServeCommand;
use Axiom\Database\Commands\GenerateMigrationCommand;
use Axiom\Database\Commands\MigrateCommand;
use Axiom\Database\Commands\RollbackCommand;
use Axiom\Facade\Log;
use Exception;

/**
 * Kernel Class
 *
 * The command-line application kernel responsible for registering and executing commands.
 * This class handles command routing, argument parsing, and error handling.
 */
class Kernel
{
    /** @var array The registered commands */
    protected array $commands = [];

    /**
     * Kernel Constructor
     *
     * Initializes the kernel and registers the available commands.
     */
    public function __construct()
    {
        $this->commands = [
            'project-cache:clear' => AppCashClearCommand::class,
            'project-start' => AppServeCommand::class,
            'app-create' => CreateApplicationCommand::class,
            'app-delete' => DeleteApplicationCommand::class,
            
            //Help
            'help:entity' => EntityHelpCommand::class,

            // Migration commands
            'migrations:migrate' => MigrateCommand::class,
            'migrations:rollback' => RollbackCommand::class,
            'migrations:generate' => GenerateMigrationCommand::class,
        ];
    }

    /**
     * Handle the command-line request.
     *
     * @param array $argv The command-line arguments
     * @return void
     */
    public function handle(array $argv): void
    {
        try {
            if (count($argv) < 2) {
                $this->showHelp();
                return;
            }

            $this->runCommand($argv);
        } catch (Exception $e) {
            Log::error($e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            Preview::error($e->getMessage());
        }
    }

    /**
     * Execute the specified command.
     *
     * @param array $argv The command-line arguments
     * @return void
     * @throws Exception If the command is not found
     */
    protected function runCommand(array $argv): void
    {
        $command = $argv[1];

        if (isset($this->commands[$command])) {
            $class = $this->commands[$command];
            (new $class())->setArguments(array_slice($argv, 2))->handle();
        } else {
            throw new Exception("Command '{$command}' not found.");
        }
    }

    /**
     * Display the list of available commands.
     *
     * @return void
     */
    protected function showHelp(): void
    {
        Preview::info('Available commands:');

        foreach ($this->commands as $command => $class) {
            Preview::info($command);
        }
    }
}