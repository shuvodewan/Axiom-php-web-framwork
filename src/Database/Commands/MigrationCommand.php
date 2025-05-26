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
        $migrationsConfig = config('database.migrations');
    
        // Create and configure the migrations table storage
        $storageConfig = new \Doctrine\Migrations\Metadata\Storage\TableMetadataStorageConfiguration();
        $storageConfig->setTableName($migrationsConfig['table_storage']['table_name']);
        $storageConfig->setVersionColumnName($migrationsConfig['table_storage']['version_column_name']);
        $storageConfig->setVersionColumnLength($migrationsConfig['table_storage']['version_column_length']);
        $storageConfig->setExecutedAtColumnName($migrationsConfig['table_storage']['executed_at_column_name']);
    
        // Create main configuration
        $config = new Configuration();
        $config->setMetadataStorageConfiguration($storageConfig);
        $config->addMigrationsDirectory(
            key($migrationsConfig['migrations_paths']), 
            $migrationsConfig['migrations_paths'][key($migrationsConfig['migrations_paths'])]
        );
        $config->setAllOrNothing($migrationsConfig['all_or_nothing']);
        $config->setCheckDatabasePlatform($migrationsConfig['check_database_platform']);
    
        $dbManager = DatabaseManager::getInstance();
        $connection = $dbManager->getConnection();
        $em = $dbManager->getEntityManager();
    
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
        $application = new \Symfony\Component\Console\Application('Axiom Migrations');
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


    public function getVersion(string $version) :string
    {
        return key(config('database.migrations.migrations_paths')). '\\' . 'Version' . $version;
    }

    abstract protected function getMigrationCommandName(): string;
}