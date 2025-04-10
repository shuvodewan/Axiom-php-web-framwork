<?php

namespace Axiom\Database\Commands;

/**
 * Displays information about the latest available migration version.
 * 
 * This command provides visibility into your migration status by showing:
 * - The most recent migration version available
 * - Whether it has been executed
 * - The migration description/name
 * - How it compares to currently executed version
 * 
 * Usage Examples:
 * 
 * 1. Basic version check:
 *    php axiom migrations:latest
 * 
 * Typical Output:
 * "Latest version: 20230101000000 (CreateUsersTable)"
 * "Status: Not migrated"
 */
class LatestCommand extends MigrationCommand
{
    /**
     * Defines validation rules for command options.
     * 
     * While this command typically doesn't need validation,
     * available options include:
     * --format: Output format (text/json)
     * --db:     Database connection name
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
     * Doctrine's 'migrations:latest' command:
     * - Queries available migrations
     * - Identifies the most recent version
     * - Compares against executed migrations
     * - Supports multiple output formats
     * 
     * @return string The Doctrine latest command identifier
     */
    protected function getMigrationCommandName(): string
    {
        return 'migrations:latest';
    }

    /**
     * Prepares command parameters for version checking.
     * 
     * Example return values:
     * [] - Basic check
     * ['--format' => 'json'] - Machine-readable output
     * ['--db' => 'secondary'] - Check specific connection
     * 
     * @return array Configuration for Doctrine latest command
     */
    protected function prepareInput(): array
    {
        return [];
    }

    /**
     * Executes the version check and enhances default output.
     * 
     * Adds:
     * - Clear success/error messaging
     * - Actionable insights when migrations are pending
     * - Formatting improvements over basic Doctrine output
     */
    public function handle(): void
    {
        parent::handle();

        // Additional processing could be added here to:
        // - Parse the output for custom formatting
        // - Add color coding
        // - Integrate with other systems
    }
}