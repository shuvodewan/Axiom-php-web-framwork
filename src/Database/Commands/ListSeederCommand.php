<?php

namespace Axiom\Database\Commands;

use Axiom\Application\AppManager;
use Axiom\Console\Command;
use Axiom\Filesystem\Filesystem;
use Database\Seeders\DatabaseSeeder;
use Exception;

/**
 * A console command to list all available database seeders in the application.
 *
 * This command scans both the framework's seeders directory and application-specific
 * seeders, then displays them in a formatted table with their names, application context,
 * class names, and full namespace paths.
 */
class ListSeederCommand extends Command
{
   
    /**
     * Define validation rules for command arguments (not used in this command).
     *
     * @return array An empty array as this command doesn't accept arguments
     */
    protected function validator(): array
    {
        return [];
    }

    /**
     * Retrieve all available seeders from both framework and application contexts.
     *
     * Combines seeders from:
     * 1. The framework's Database/Seeders directory
     * 2. Application-specific seeders registered via AppManager
     *
     * @return array An associative array of seeder classes with:
     *               - Key: The base filename (without extension)
     *               - Value: The fully qualified class name
     */
    private function getSeeders(): array
    {
        $files = (new Filesystem(database_path('/Seeders')))->files();

        $appSeeders = AppManager::getInstance()->getSeeders();
        
        $databaseSeeders = array_combine(
            array_map(fn($f) => pathinfo($f, PATHINFO_FILENAME), $files),
            array_map(fn($f) => 'Axiom\\Database\\Seeders\\' . pathinfo($f, PATHINFO_FILENAME), $files)
        );

        return array_merge($appSeeders, $databaseSeeders);
    }

    /**
     * Execute the console command.
     *
     * Compiles seeder information into a formatted table and displays it.
     * The table includes:
     * - Seeder name (with application context if namespaced)
     * - Application context (if applicable)
     * - Class name
     * - Full seeder class path
     *
     * @return void
     */
    public function handle(): void
    {
        $tableData = [];

        foreach ($this->getSeeders() as $key => $seeder) {
            // Split the key by dots to separate application context from seeder name
            $name = explode('.', $key);
            
            $tableData[] = [
                'Name'          => count($name) > 1 ? end($name) : $name[0],  
                'Application'   => count($name) > 1 ? $name[0] : '',          
                'Class'         => $key,                                      
                'Seeder'        => $seeder,                                 
            ];
        }

        // Display the compiled seeder information as a table
        $this->table($tableData);
    }
}