<?php

namespace Axiom\Database\Commands;

use Axiom\Application\AppManager;
use Axiom\Console\Command;
use Axiom\Filesystem\Filesystem;
use Database\Seeders\DatabaseSeeder;
use Exception;

/**
 * Console command for database population with seed data.
 * 
 * Handles execution of database seeders either individually or collectively.
 */
class PopulateSeeder extends Command
{
    /**
     * Filesystem instance for directory scanning.
     * 
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Define validation rules for command arguments.
     * 
     * @return array<string, string> Validation rules
     */
    protected function validator(): array
    {
        return [
            'class' => 'nullable|string',
            'app' => 'nullable|string'
        ];
    }

    /**
     * Retrieves all available seeder classes.
     * 
     * Combines framework seeders with application-registered seeders.
     * 
     * @return array<string, string> Map of seeder names to class names
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
     * Executes the seeding operation.
     * 
     * Runs either a specific seeder or the default DatabaseSeeder.
     * 
     * @throws Exception When specified seeder is not found
     */
    public function handle(): void
    {
        if ($class = $this->argument('class')) {
            $seeders = $this->getSeeders();

            if (!array_key_exists($class, $seeders)) {
                throw new Exception("{$class} seeder not found!");
            }

            (new $seeders[$class]())->call();
        }elseif($app = $this->argument('app')) {
            $manager = AppManager::getInstance();
            if (!$manager->isRegistered($app)) {
                throw new Exception("{$app} not a valid app!");
            }
            foreach($manager->getSeedersByApp($app) as $seeder){
                (new $seeder())->call();
            }
           
        } else {
            (new DatabaseSeeder())->run();
        }
    }
}