<?php

namespace Axiom\Database\Commands;

use Symfony\Component\Console\Input\InputOption;

/**
 * Handles database migration rollbacks with safety and flexibility.
 * 
 * This command provides controlled reversal of migrations with:
 * - Single migration or batch rollback options
 * - Dry-run capability for safety checks
 * - Query time measurement
 * - Force mode for skipping confirmation
 * - Transaction protection
 * 
 * Usage Examples:
 * 
 * 1. Rollback last migration:
 *    php axiom migrations:rollback
 * 
 * 2. Dry-run to preview rollback SQL:
 *    php axiom migrations:rollback --dry-run
 * 
 * 3. Rollback all migrations:
 *    php axiom migrations:rollback --all
 * 
 * 4. Force rollback without confirmation:
 *    php axiom migrations:rollback --force
 * 
 * 5. With query timing:
 *    php axiom migrations:rollback --query-time
 */
class RollbackCommand extends MigrationCommand
{
    /**
     * Defines validation rules for command options.
     * 
     * Rules ensure:
     * - Proper boolean values for flags
     * - Safe parameter combinations
     * - Required format for version targeting
     * 
     * @return array Validation rules
     */
    protected function validator(): array
    {
        return [
            'dry-run' => 'nullable|boolean',
            'query-time' => 'nullable|boolean',
            'all' => 'nullable|boolean',
            'force' => 'nullable|boolean',
            'version' => 'nullable|string|regex:/^\d{14}$/'
        ];
    }

    /**
     * Configure the command options.
     */
    protected function configure()
    {
        $this->addOption(
            'pretend',
            null,
            InputOption::VALUE_NONE,
            'Dump the SQL queries that would be run'
        );
    }

    /**
     * Specifies the underlying Doctrine rollback command.
     */
    protected function getMigrationCommandName(): string
    {
        return 'migrations:execute'; // Using execute with --down for rollback
    }

    /**
     * Prepares input parameters with enhanced safety checks.
     * 
     * Adds:
     * - Version targeting support
     * - Pretend mode (alternative to dry-run)
     * - Automatic confirmation for non-interactive environments
     * 
     * @return array Prepared parameters
     */
    protected function prepareInput(): array
    {
        $input = [
            '--down' => true, // Essential for rollback behavior
            '--no-interaction' => !$this->isInteractive(),
        ];

        // Handle version-specific rollback
        if ($version = $this->argument('version')) {
            $input['versions'] = [$version];
        }

        // Set options from arguments
        foreach (['dry-run', 'query-time', 'all', 'force'] as $option) {
            if ($this->argument($option)) {
                $input['--'.$option] = true;
            }
        }

        // Support pretend mode as alternative to dry-run
        if ($this->option('pretend')) {
            $input['--dry-run'] = true;
        }

        return $input;
    }

    /**
     * Executes the command with enhanced feedback and safety.
     */
    public function handle(): void
    {
        try {
            parent::handle();
            
            $message = 'Rollback completed successfully';
            if ($this->argument('dry-run') || $this->option('pretend')) {
                $message .= ' (dry run)';
            }
            
            $this->info($message);
            
        } catch (\Exception $e) {
            $this->error('Rollback failed: '.$e->getMessage());
            $this->line('Suggestions:');
            $this->line('- Use --dry-run to preview changes');
            $this->line('- Check database connection');
            $this->line('- Verify migration status with migrations:status');
            throw $e;
        }
    }
}