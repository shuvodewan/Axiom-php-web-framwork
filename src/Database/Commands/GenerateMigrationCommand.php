<?php

namespace Axiom\Database\Commands;

use Symfony\Component\Console\Input\InputArgument;

/**
 * Creates new blank migration files for manual schema modifications.
 * 
 * This command generates template migration files that can be used to:
 * - Create custom database schema changes
 * - Implement data migrations
 * - Add complex SQL not handled by automatic diff
 * - Maintain versioned database changes
 * 
 * Usage Examples:
 * 
 * 1. Create a basic migration:
 *    php axiom migrations:generate CreateUsersTable
 * 
 * 2. Generate migration with specific name:
 *    php axiom migrations:generate "AddEmailVerificationColumns"
 * 
 * 3. Create namespaced migration:
 *    php axiom migrations:generate "Core\\CreatePermissionsTable"
 * 
 * Generated files include:
 * - Up() method for applying changes
 * - Down() method for reverting changes
 * - Timestamped filename (YYYYMMDDHHMMSS_Description.php)
 */
class GenerateMigrationCommand extends MigrationCommand
{
    /**
     * Defines validation rules for command arguments.
     * 
     * Rules:
     * - 'name' (required): Descriptive name for the migration
     *   - Must be string
     *   - Can include namespace separators (\\)
     *   - Should describe the migration purpose
     * 
     * Example Valid Inputs:
     * - "CreateUsersTable"
     * - "Core\\SetupPermissions"
     * - "AddIndexToPostsTable"
     */
    protected function validator(): array
    {
        return [
            'name' => 'required|string',
        ];
    }

    /**
     * Specifies the underlying Doctrine migration command.
     * 
     * Doctrine's 'migrations:generate' command:
     * - Creates blank migration class template
     * - Generates timestamped filename
     * - Sets up basic class structure
     * 
     * @return string The Doctrine generate command identifier
     */
    protected function getMigrationCommandName(): string
    {
        return 'migrations:generate';
    }

    /**
     * Prepares command parameters for migration generation.
     * 
     * Example return value:
     * [
     *   '--namespace' => 'Database\\Migrations',
     *   'name' => 'CreateUsersTable'
     * ]
     * 
     * @return array Configuration for Doctrine generate command
     */
    protected function prepareInput(): array
    {
        return [
            // Fixed namespace for organization
            '--namespace' => 'Database\\Migrations',
            
            // Pass the migration name to Doctrine
            'name' => $this->argument('name')
        ];
    }

    /**
     * Executes the generation command and provides user feedback.
     * 
     * Outputs:
     * - Success message with generated filename
     * - Location of created file
     * - Next steps for implementation
     * 
     * Files are created in:
     * /database/migrations/YYYYMMDDHHMMSS_Description.php
     */
    public function handle(): void
    {
        parent::handle();
        
        $this->info(sprintf(
            'Migration template "%s" created successfully in Database\Migrations namespace',
            $this->argument('name')
        ));
        
        $this->line('Next steps:');
        $this->line('- Implement the up() method for your schema changes');
        $this->line('- Define the down() method to revert those changes');
        $this->line('- Run migrations:migrate to execute your migration');
    }
}