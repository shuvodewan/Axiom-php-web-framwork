<?php

namespace Axiom\Database\Commands;

/**
 * Generates migration files by comparing database schema with entity mappings.
 * 
 * This command automates migration file creation by detecting:
 * - New tables needed based on entities
 * - Pending column changes (added/removed columns)
 * - Required index/constraint modifications
 * - Schema differences between current DB and entity definitions
 * 
 * Usage Examples:
 * 
 * 1. Generate migration for all detected changes:
 *    php axiom migrations:diff
 * 
 * 2. Generate migration only for specific tables (comma-separated):
 *    php axiom migrations:diff --filter=users,posts
 * 
 * 3. Generate migration excluding certain tables:
 *    php axiom migrations:diff --filter='^(?!(migrations|cache_.*)$)'
 * 
 * 4. Preview SQL without generating migration file:
 *    php axiom migrations:diff --dry-run
 */
class DiffCommand extends MigrationCommand
{
    /**
     * Defines validation rules for command options.
     * 
     * Currently no validation needed as:
     * - Namespace is hardcoded to 'Axiom\Database\Migrations'
     * - Filter accepts any valid regex pattern
     * - Dry-run is boolean flag
     * 
     * @return array Empty array indicates no validation requirements
     */
    protected function validator(): array
    {
        return [];
    }

    /**
     * Specifies the underlying Doctrine migration command.
     * 
     * Doctrine's 'migrations:diff' command:
     * - Compares current database schema with entity metadata
     * - Generates migration class with necessary DDL statements
     * - Supports complex table filtering with regex
     * - Can output to file or console
     * 
     * @return string The Doctrine diff command identifier
     */
    protected function getMigrationCommandName(): string
    {
        return 'migrations:diff';
    }

    /**
     * Prepares command parameters for schema comparison.
     * 
     * Example return value:
     * [
     *   '--namespace' => 'Database\Migrations',
     *   '--filter-expression' => 'users|posts',
     *   '--formatted' => true,
     *   '--dry-run' => false
     * ]
     * 
     * @return array Configuration for Doctrine diff command
     */
    protected function prepareInput(): array
    {
        return [
            // Fixed namespace for generated migrations
            '--namespace' => key(config('database.migrations.migrations_paths')),
            
            // Table filter (supports regex patterns)
            '--filter-expression' => $this->argument('filter') ?: '',
        ];
    }

    /**
     * Executes the diff command and provides user feedback.
     * 
     * Example Outputs:
     * - "Generated migration 20230101000000 (3 changes detected)"
     * - "Dry run complete - would generate 2 schema changes"
     * - "No schema changes detected"
     * 
     * Generated files are saved to:
     * /database/migrations/YYYYMMDDHHMMSS_VersionName.php
     */
    public function handle(): void
    {
        parent::handle();
        
        if ($this->option('dry-run')) {
            $this->info('Dry run complete - review proposed changes above');
        } else {
            $this->info('Migration file generated successfully');
        }
    }
}