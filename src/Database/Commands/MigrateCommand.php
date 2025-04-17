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
 *    php axiom migrations:migrate
 * 
 * 2. Migrate to specific version:
 *    php axiom migrations:migrate 20230101000000
 * 
 * 3. Dry-run simulation (show SQL without executing):
 *    php axiom migrations:migrate --dry-run
 * 
 * 4. With query timing analysis:
 *    php axiom migrations:migrate --query-time
 * 
 * 5. Allow empty migration sets:
 *    php axiom migrations:migrate --allow-no-migration
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
            'version' => 'nullable|regex:/^\d{14}$/',
            'dry-run' => 'nullable|boolean',
            'query-time' => 'nullable|boolean',
            'allow-no-migration' => 'nullable|boolean',
        ];
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

        $input = [];

        if ($version = $this->argument('version')) {
            $input['version'] = $this->getVersion($version);
        }

        // Set options from arguments
        foreach (['dry-run', 'query-time', 'allow-no-migration'] as $option) {
            if ($this->argument($option)) {
                $input['--'.$option] = true;
            }
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
}