<?php

namespace Axiom\Database\Commands;

/**
 * Displays the complete migration status overview.
 * 
 * Shows the synchronization state between:
 * - Available migration files in your codebase
 * - Executed migrations recorded in your database
 * 
 * This command helps you:
 * - Identify pending migrations that need to be run
 * - Verify which migrations have already been executed
 * - Detect potential inconsistencies in your migration history
 * 
 * Basic Usage:
 * php axiom migrations:status
 * 
 * Example Output:
 * +----------------+--------------------------------+---------------------+
 * | Version        | Description                    | Executed At         |
 * +----------------+--------------------------------+---------------------+
 * | 20230101000000 | Create users table             | 2023-01-01 10:00:00 |
 * | 20230102000000 | Add email verification column  | Not migrated        |
 * +----------------+--------------------------------+---------------------+
 * 
 * Common Use Cases:
 * 1. Before deployment - check for pending migrations:
 *    php axiom migrations:status
 * 
 * 2. After deployment - verify all migrations ran:
 *    php axiom migrations:status
 * 
 * 3. When troubleshooting - check migration state:
 *    php axiom migrations:status
 */
class StatusCommand extends MigrationCommand
{
    /**
     * No validation required because:
     * - This command takes no arguments
     * - It requires no configuration
     * - It has no optional parameters
     * 
     * @return array Empty array indicates no validation needed
     */
    protected function validator(): array
    {
        return [];
    }

    /**
     * Specifies Doctrine's status command.
     * 
     * The 'migrations:status' command provides:
     * - A complete migration timeline
     * - Version comparison between code and database
     * - Clear execution status for each migration
     * - Information about the current version
     * 
     * @return string The Doctrine command identifier
     */
    protected function getMigrationCommandName(): string
    {
        return 'migrations:status';
    }

    /**
     * No input preparation needed because:
     * - The command requires no transformation of inputs
     * - It works with default Doctrine configuration
     * - All parameters come from the migration storage
     * 
     * @return array Empty array as no preparation is needed
     */
    protected function prepareInput(): array
    {
        return [];
    }

    /**
     * Executes the status check using parent functionality.
     * 
     * The output will show:
     * - All available migrations
     * - Their execution status
     * - Execution timestamps (for migrated versions)
     * - Current database version
     */
    public function handle(): void
    {
        parent::handle();
    }
}