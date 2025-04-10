<?php

namespace Axiom\Database\Commands;

/**
 * Handles execution of specific database migrations, allowing both 
 * forward (up) and backward (down) migration of individual versions.
 * 
 * Usage Examples:
 * 
 * 1. Execute a migration forward (apply changes):
 *    php axiom migrations:execute 20230101000000 up=1
 * 
 * 2. Rollback a specific migration (revert changes):
 *    php axiom migrations:execute 20230101000000 down=1
 * 
 * 3. With dry-run to preview SQL without executing:
 *    php axiom migrations:execute 20230101000000 up=1 dry-run=1
 * 
 * 4. Multiple versions (comma-separated):
 *    php axiom migrations:execute 20230101000000,20230201000000 up=1
 */
class ExecuteMigrationCommand extends MigrationCommand
{
    /**
     * Defines validation rules for command arguments.
     * 
     * Rules:
     * - 'version' (required): The migration version to execute (e.g. "20230101000000")
     * - 'up' (optional): Boolean flag to migrate up (e.g. "up=1")
     * - 'down' (optional): Boolean flag to migrate down (e.g. "down=1")
     * 
     * Example Valid Inputs:
     * [
     *   'version' => '20230101000000',
     *   'up' => '1'
     * ]
     */
    protected function validator(): array
    {
        return [
            'version' => 'required|string',  // Format: YYYYMMDDHHMMSS
        ];
    }

    /**
     * Specifies the underlying Doctrine migration command.
     * 
     * Example Doctrine Command:
     * migrations:execute 20230101000000 --up
     */
    protected function getMigrationCommandName(): string
    {
        return 'migrations:execute';
    }

    /**
     * Prepares input parameters for Doctrine migration execution.
     * 
     * Example Output:
     * [
     *   'versions' => ['20230101000000'],
     *   '--up' => true,
     *   '--down' => false,
     *   '--dry-run' => false
     * ]
     */
    protected function prepareInput(): array
    {
        $input = [
            'versions' => explode(',', $this->argument('version')),
            '--up' => $this->argument('up') ?: false,
            '--down' => $this->argument('down') ?: false,
        ];

        if ($this->argument('dry-run')) {
            $input['--dry-run'] = true;
        }

        return $input;
    }

    /**
     * Executes the migration command and provides user feedback.
     * 
     * Example Output:
     * "Migration 20230101000000 executed successfully (up)."
     * "Migration 20230101000000 rolled back successfully (down)."
     */
    public function handle(): void
    {
        parent::handle();
        
        $direction = $this->argument('up') ? 'up' : 'down';
        $this->info(sprintf(
            'Migration %s executed successfully (%s).',
            $this->argument('version'),
            $direction
        ));
    }
}