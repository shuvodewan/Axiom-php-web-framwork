<?php

namespace Axiom\Database\Commands;

use Axiom\Console\Command;
use Axiom\Database\DatabaseManager;
use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Configuration\Connection\ExistingConnection;
use Doctrine\Migrations\Configuration\Migration\ExistingConfiguration;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Tools\Console\ConsoleRunner;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;

abstract class MigrationCommand extends Command
{
    protected DependencyFactory $dependencyFactory;

    public function __construct()
    {
        $this->dependencyFactory = $this->createDependencyFactory();
    }

    protected function createDependencyFactory(): DependencyFactory
    {
        $config = new Configuration();
        $config->addMigrationsDirectory(
            'Database\Migrations', 
            database_path('/migrations')
        );
        $config->setAllOrNothing(true);
        $config->setCheckDatabasePlatform(false);

        return DependencyFactory::fromConnection(
            new ExistingConfiguration($config),
            new ExistingConnection(DatabaseManager::getInstance()->getConnection())
        );
    }

    public function handle(): void
    {
        $commandName = $this->getMigrationCommandName();
        
        // Create a new application with migration commands
        $application = new \Symfony\Component\Console\Application('Doctrine Migrations');
        ConsoleRunner::addCommands($application, $this->dependencyFactory);
        
        // Find and execute the command
        $command = $application->find($commandName);
        $input = new ArrayInput(array_merge(
            ['command' => $commandName],
            $this->prepareInput()
        ));
        
        $output = new ConsoleOutput();
        $command->run($input, $output);
    }

    abstract protected function getMigrationCommandName(): string;
}