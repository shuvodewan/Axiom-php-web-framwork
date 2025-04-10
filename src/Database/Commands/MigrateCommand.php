<?php

namespace Axiom\Database\Commands;

use Symfony\Component\Console\Input\InputOption;

/**
 * Handles database migrations by executing pending migration files.
 * 
 * This comprehensive migration command provides:
 * - Complete migration execution to latest or specific version
 * - Safety features including dry-run simulations
 * - Performance analysis with query timing
 * - Flexible handling of empty migration states
 * - Transactional execution for reliability
 * 
 * Usage Examples:
 * 
 * 1. Migrate to latest version:
 *    php axiom migrate
 * 
 * 2. Migrate to specific version:
 *    php axiom migrate 20230101000000
 * 
 * 3. Dry-run simulation (show SQL without executing):
 *    php axiom migrate --dry-run
 * 
 * 4. With query timing analysis:
 *    php axiom migrate --query-time
 * 
 * 5. Allow empty migration sets:
 *    php axiom migrate --allow-no-migration
 */
class MigrateCommand extends MigrationCommand
{
    /**
     * Defines validation rules for command arguments/options.
     * 
     * Rules enforce:
     * - Version format (YYYYMMDDHHMMSS) when specified
     * - Proper boolean values for flags
     * - Safe parameter combinations
     * 
     * @return array Validation rules
     */
    protected function validator(): array
    {
        return [
            'version' => 'nullable|regex:/^\d{14}$/', // Validate version format
            'dry-run' => 'nullable|boolean',
            'query-time' => 'nullable|boolean',
            'allow-no-migration' => 'nullable|boolean',
            'timeout' => 'nullable|integer|min:1' // New timeout option
        ];
    }

    /**
     * Configure the command options.
     */
    protected function configure()
    {
        $this->addOption(
            'timeout',
            null,
            InputOption::VALUE_OPTIONAL,
            'Database operation timeout in seconds',
            null
        );
    }

    /**
     * Specifies the underlying Doctrine migration command.
     */
    protected function getMigrationCommandName(): string
    {
        return 'migrations:migrate';
    }

    /**
     * Prepares input parameters with enhanced functionality.
     * 
     * Adds:
     * - Timeout configuration
     * - Automatic --no-interaction flag for CI environments
     * - Environment-based default options
     * 
     * @return array Prepared parameters
     */
    protected function prepareInput(): array
    {
        $input = [
            '--no-interaction' => !$this->isInteractive(),
        ];

        if ($version = $this->argument('version')) {
            $input['version'] = $version;
        }

        // Set options from arguments
        foreach (['dry-run', 'query-time', 'allow-no-migration'] as $option) {
            if ($this->argument($option)) {
                $input['--'.$option] = true;
            }
        }

        // Add timeout if specified
        if ($timeout = $this->option('timeout')) {
            $input['--timeout'] = $timeout;
        }

        return $input;
    }

    /**
     * Executes the command with enhanced feedback.
     */
    public function handle(): void
    {
        try {
            parent::handle();
            
            $message = 'Migration completed successfully';
            if ($this->argument('dry-run')) {
                $message .= ' (dry run)';
            }
            
            $this->info($message);
            
        } catch (\Exception $e) {
            $this->error('Migration failed: '.$e->getMessage());
            $this->line('Consider using --dry-run to diagnose issues');
            throw $e;
        }
    }

    /**
     * Check if command is running in interactive mode.
     */
    protected function isInteractive(): bool
    {
        return $this->input->isInteractive() && !$this->option('no-interaction');
    }
}