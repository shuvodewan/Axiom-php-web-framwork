<?php

namespace Axiom\Application\Commands;

use Axiom\Application\ApplicationGeneratorTrait;
use Axiom\Console\Command;
use Axiom\Filesystem\LocalDriver;

/**
 * ControllerGeneratorCommand Class
 *
 * A console command for generating model files in the application.
 * This command uses stubs to create model files with the appropriate namespace and class name.
 */
class ControllerGeneratorCommand extends Command
{
    use ApplicationGeneratorTrait;

    /** @var string The application name */
    protected string $app;

    /** @var LocalDriver The filesystem instance */
    protected LocalDriver $filesystem;

    /** @var string The model name */
    protected string $name;

    /** @var array The items to generate (e.g., model files) */
    protected array $items;

    /**
     * Define validation rules for command arguments.
     *
     * @return array The validation rules
     */
    protected function validator(): array
    {
        return [
            'app' => [
                'required'
            ],
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
        $this->info('Generating controller...');

        // Initialize the filesystem instance
        $this->filesystem = new LocalDriver(['root' => app_path()]);

        // Set the application and model name
        $this->app = $app ?? $this->argument('app');
        $this->name = $name ?? $this->argument('name');

        // Define the items to generate
        $this->items = [
            "Controller" => [
                "dir" => ucfirst($this->app) . '/Controllers/',
                "file" => $this->getSingularClassName($this->name) . 'Controller.php',
            ],
        ];
    }

    /**
     * Map the stub variables present in the stub to their values.
     *
     * @return array The stub variables as key-value pairs
     */
    public function getStubVariables(): array
    {
        return [
            'NAMESPACE' => ucfirst($this->app),
            'CLASS_NAME' => $this->getSingularClassName($this->name),
            'SERVICE' => $this->getSingularClassName($this->name),
        ];
    }
}