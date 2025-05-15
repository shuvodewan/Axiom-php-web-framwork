<?php

namespace Axiom\Console;

use Axiom\Application\Commands\ControllerGeneratorCommand;
use Axiom\Application\Commands\CreateApplicationCommand;
use Axiom\Application\Commands\DeleteApplicationCommand;
use Axiom\Application\Commands\EntityGeneratorCommand;
use Axiom\Application\Commands\EntityHelpCommand;
use Axiom\Application\Commands\ServiceGeneratorCommand;
use Axiom\Console\Commands\AppCashClearCommand;
use Axiom\Console\Commands\AppServeCommand;
use Axiom\Database\Commands\DiffCommand;
use Axiom\Database\Commands\ExecuteMigrationCommand;
use Axiom\Database\Commands\GenerateMigrationCommand;
use Axiom\Database\Commands\LatestCommand;
use Axiom\Database\Commands\ListCommand;
use Axiom\Database\Commands\MakeSeederCommand;
use Axiom\Database\Commands\MigrateCommand;
use Axiom\Database\Commands\PopulateSeeder;
use Axiom\Database\Commands\RollbackCommand;
use Axiom\Database\Commands\StatusCommand;
use Axiom\Database\Commands\SyncMetadataCommand;
use Axiom\Database\Commands\VersionCommand;
use Axiom\Facade\Log;
use Axiom\Http\Commands\RouteListCommand;
use Axiom\Messenger\Commands\WorkerCommand;
use Axiom\Messenger\QueueWorker;
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
            'cache:clear' => AppCashClearCommand::class,
            'project:start' => AppServeCommand::class,
            'app:create' => CreateApplicationCommand::class,
            'app:delete' => DeleteApplicationCommand::class,
            'app:entity'=> EntityGeneratorCommand::class,
            'app:service'=> ServiceGeneratorCommand::class,
            'app:controller'=> ControllerGeneratorCommand::class,

            'queue:work'=>WorkerCommand::class,
            
            //Help
            'help:entity' => EntityHelpCommand::class,

            // Migration commands
            'migrations:migrate' => MigrateCommand::class,
            'migrations:rollback' => RollbackCommand::class,
            'migrations:generate' => GenerateMigrationCommand::class,
            'migrations:latest' => LatestCommand::class,
            'migrations:list' => ListCommand::class,
            'migrations:status' => StatusCommand::class,
            'migrations:sync' => SyncMetadataCommand::class,
            'migrations:version' => VersionCommand::class,
            'migrations:execute' => ExecuteMigrationCommand::class,
            'migrations:diff' => DiffCommand::class,

            //seeders

            'seeder:generate'=>MakeSeederCommand::class,
            'seeder:populate'=>PopulateSeeder::class,

            //Routes

            'route:list'=>RouteListCommand::class
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