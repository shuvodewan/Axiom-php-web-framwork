<?php

namespace Axiom\Database\Commands;

use Axiom\Console\Command;
use Axiom\Database\DatabaseManager;
use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Configuration\Connection\ExistingConnection;
use Doctrine\Migrations\Configuration\Migration\ExistingConfiguration;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Tools\Console\ConsoleRunner;
use Doctrine\ORM\EntityManager;
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
            'Database\\Migrations', 
            database_path('/Migrations')
        );
        $config->setAllOrNothing(true);
        $config->setCheckDatabasePlatform(false);

        // Get both the connection and entity manager
        $dbManager = DatabaseManager::getInstance();
        $connection = $dbManager->getConnection();
        $em = $dbManager->getEntityManager();

        // Use fromEntityManager when available, fallback to fromConnection
        return $em instanceof EntityManager
            ? DependencyFactory::fromEntityManager(
                new ExistingConfiguration($config),
                new \Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager($em)
            )
            : DependencyFactory::fromConnection(
                new ExistingConfiguration($config),
                new ExistingConnection($connection)
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