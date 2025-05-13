<?php

namespace Axiom\Database\Commands;

use Axiom\Application\ApplicationGeneratorTrait;
use Axiom\Console\Command;
use Axiom\Facade\Str;
use Axiom\Filesystem\LocalDriver;
use Exception;

/**
 * SeederCommand Class
 *
 * A console command for generating model files in the application.
 * This command uses stubs to create model files with the appropriate namespace and class name.
 */
class MakeSeederCommand extends Command
{
    use ApplicationGeneratorTrait;

    protected string $stub ='/Database/Stubs/';

    /** @var string The application name */
    protected string $app;

    /** @var LocalDriver The filesystem instance */
    protected LocalDriver $filesystem;

    /** @var string The model name */
    protected string $name;

    /** @var array The items to generate (e.g., model files) */
    protected array $items;

    public function __construct()
    {
        $this->filesystem = new LocalDriver(['root' => database_path()]);
    }

    /**
     * Define validation rules for command arguments.
     *
     * @return array The validation rules
     */
    protected function validator(): array
    {
        return [
            'name' => 'required|max:50',
        ];
    }


    /**
     * Set the data required for generating the model.
     *
     * @param string|null $app The application name
     * @param string|null $name The model name
     * @return void
     */
    protected function setData(?string $app = null, ?string $name = null): void
    {

        // Set the application and seeder name
        $this->name = $name ?? $this->argument('name');

        if($this->filesystem->has('Seeders/'. $this->getSingularClassName($this->name) . '.php')){
            throw new Exception($this->getSingularClassName($this->name). '.php' . ' Seeder exist!');
        }
        // dd($this->getSingularClassName($this->name) . '.php');
        $this->info('Generating seeder...');

        // Define the items to generate
        $this->items = [
            "Seeder" => [
                "dir" => 'Seeders/',
                "file" => $this->getSingularClassName($this->name) . '.php',
            ],
        ];
    }


    protected function closing()
    {
        $this->info('Seeder generated');
    }

    /**
     * Map the stub variables present in the stub to their values.
     *
     * @return array The stub variables as key-value pairs
     */
    public function getStubVariables(): array
    {
        return [
            'CLASS_NAME' => $this->getSingularClassName($this->name),
        ];
    }
}