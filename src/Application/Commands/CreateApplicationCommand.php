<?php

namespace Axiom\Application\Commands;

use Axiom\Application\AppManager;
use Axiom\Console\Command;
use Axiom\Filesystem\Filesystem;
use Axiom\Filesystem\LocalDriver;
use Exception;

/**
 * CreateApplicationCommand Class
 *
 * A console command for creating new applications in the framework.
 * This command handles tasks such as checking for uniqueness, creating directories,
 * deleting existing unregistered applications, and generating application files.
 */
class CreateApplicationCommand extends Command
{
    /** @var AppManager The application manager instance */
    protected AppManager $app;

    /** @var LocalDriver The filesystem instance */
    protected LocalDriver $filesystem;

    /**
     * CreateApplicationCommand Constructor
     *
     * Initializes the application manager and filesystem instances.
     */
    public function __construct()
    {
        $this->app = new AppManager();
        $this->filesystem = new LocalDriver(['root' => app_path()]);
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
            'entity'=>'nullable|max:50',
            'controller'=>'nullable|max:50',
            'service'=>'nullable|max:50',
        ];
    }

    /**
     * Handle the command execution.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->info('Creating application...');

        try {
            $this->checkUnique()
                 ->createAppDir()
                 ->deleteExisting()
                 ->generateApplication();

            $this->end('Application created successfully.');
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * Check if the application name is unique.
     *
     * @return $this
     * @throws Exception If the application name already exists
     */
    private function checkUnique(): self
    {
        $this->info('Checking application uniqueness...');

        $name = $this->argument('name');
        if ($this->app->isRegistered($name)) {
            throw new Exception("Application '$name' already exists!");
        }

        return $this;
    }

    /**
     * Delete an existing unregistered application directory.
     *
     * @return $this
     * @throws Exception If the directory cannot be deleted
     */
    private function deleteExisting(): self
    {
        $this->info('Deleting unregistered existing application...');

        $name = $this->argument('name');
        if ($this->filesystem->directoryExists($name)) {
            try {
                $this->filesystem->deleteDirectory($name);
                $this->info("Application '$name' successfully deleted.");
            } catch (Exception $e) {
                throw new Exception("Failed to delete application '$name': " . $e->getMessage());
            }
        }

        return $this;
    }

    /**
     * Create the application directory.
     *
     * @return $this
     */
    private function createAppDir(): self
    {
        $this->info('Creating application directory...');

        $name = $this->argument('name');
        if (!$this->filesystem->directoryExists($name)) {
            $this->filesystem->createDirectory($name);
        }

        return $this;
    }

    /**
     * Generate the application files.
     *
     * @return $this
     */
    private function generateApplication(): self
    {
        $this->info('Generating application files...');

        $app = $this->argument('name');
        (new AppGeneratorCommand())->handle($app, $app);
        (new EntityGeneratorCommand())->handle($app, $this->argument('entity')??$app);
        (new ServiceGeneratorCommand())->handle($app, $this->argument('service')??$app);
        (new ControllerGeneratorCommand())->handle($app, $this->argument('controller')??$app);
        // (new Filesystem(app_path('/'. ucfirst($app))))->makeDirectory('Templates');
        return $this;
    }
}