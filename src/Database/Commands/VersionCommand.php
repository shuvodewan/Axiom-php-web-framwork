<?php

namespace Axiom\Database\Commands;

/**
 * Manually manages migration versions in the version tracking table.
 * 
 * This command interacts with Doctrine's migration version storage to:
 * - Add migration versions to the tracking table (mark as completed)
 * - Remove migration versions from the tracking table (mark as pending)
 * - Verify version existence without modification
 */
class VersionCommand extends MigrationCommand
{
    /**
     * Validates the command input arguments.
     * 
     * Requires:
     * - version: The migration version timestamp (string)
     * 
     * Optional boolean flags:
     * - add: Mark version as migrated
     * - delete: Remove version from history
     * 
     * @return array Validation rules
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
     * Doctrine's 'migrations:version' command provides:
     * - Version tracking manipulation
     * - Safe version table modifications
     * - Consistency checks
     * 
     * @return string Doctrine command name
     */
    protected function getMigrationCommandName(): string
    {
        return 'migrations:version';
    }

    /**
     * Prepares the input arguments for Doctrine command.
     * 
     * Converts arguments to Doctrine's expected format:
     * - version: Passed directly
     * - add/delete: Converted to --add/--delete flags
     * 
     * @return array Prepared command arguments
     */
    protected function prepareInput(): array
    {
        return [
            'version' => $this->argument('version'),
            '--add' => $this->argument('add') ?: false,
            '--delete' => $this->argument('delete') ?: false,
        ];
    }

    /**
     * Executes the version operation and provides feedback.
     * 
     * Examples:
     * 1. php axiom migrations:version 20230101000000 --add
     *    - Adds version to tracking table
     *    - Output: "Version operation completed."
     * 
     * 2. php axiom migrations:version 20230101000000 --delete
     *    - Removes version from tracking table  
     *    - Output: "Version operation completed."
     * 
     * 3. php axiom migrations:version 20230101000000
     *    - Checks version existence
     *    - Output: "Version operation completed."
     */
    public function handle(): void
    {
        parent::handle();
        $this->info('Version operation completed.');
    }
}