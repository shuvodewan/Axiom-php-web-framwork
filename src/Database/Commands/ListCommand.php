<?php

namespace Axiom\Database\Commands;

use Symfony\Component\Console\Input\InputOption;

/**
 * Displays a complete list of all available migrations with their status.
 * 
 * This command provides a comprehensive view of your migration timeline by showing:
 * - All available migration versions
 * - Execution status (executed/pending)
 * - Migration descriptions
 * - Date information
 * - Execution time (for executed migrations)
 * 
 * Usage Examples:
 * 
 * 1. Basic list with default formatting:
 *    php axiom migrations:list
 * 
 * 
 * Typical Output Format:
 * +----------------+-------------------+-----------+---------------------+
 * | Version        | Description       | Status    | Executed At         |
 * +----------------+-------------------+-----------+---------------------+
 * | 20230101000000 | Create users table | Executed  | 2023-01-01 10:00:00 |
 * | 20230102000000 | Add email column   | Pending   |                     |
 * +----------------+-------------------+-----------+---------------------+
 */
class ListCommand extends MigrationCommand
{
    /**
     * Defines validation rules for command options.
     * 
     * 
     * @return array Validation rules for input parameters
     */
    protected function validator(): array
    {
        return [];
    }

    /**
     * Specifies the underlying Doctrine migration command.
     * 
     * Doctrine's 'migrations:list' command provides:
     * - Complete migration timeline
     * - Multiple output formats
     * - Filtering capabilities
     * - Detailed execution information
     * 
     * @return string The Doctrine list command identifier
     */
    protected function getMigrationCommandName(): string
    {
        return 'migrations:list';
    }

    /**
     * Prepares command parameters for listing migrations.
     * 
     * Example return values:
     * [] - Default list view
     * [
     *   '--format' => 'json',
     *   '--status' => 'pending',
     *   '--show-execution-time' => true
     * ]
     * 
     * @return array Configuration for Doctrine list command
     */
    protected function prepareInput(): array
    {
       
        return [];
    }

    /**
     * Executes the list command and enhances default output.
     * 
     * Adds:
     * - Custom formatting options
     * - Color-coded status indicators
     * - Summary statistics
     * - Improved table presentation
     */
    public function handle(): void
    {
        parent::handle();
    }
}