<?php

namespace Axiom\Database\Commands;

/**
 * Synchronizes the migration metadata storage with your database schema.
 * 
 * This command ensures your migration tracking table (usually named 'migrations')
 * is properly structured and aligned with Doctrine's expectations. It's particularly
 * useful in these scenarios:
 * 
 * - After restoring a database from backup
 * - When the migrations table structure changes between Doctrine versions
 * - If you've manually modified the database schema
 * - During deployment to ensure consistent tracking
 * 
 * Basic Usage:
 * php axiom migrations:sync-metadata-storage
 * 
 * Example Scenarios:
 * 
 * 1. After database restore:
 *    php axiom migrations:sync-metadata-storage
 *    # Ensures the migrations table matches current structure
 * 
 * 2. During deployment scripts:
 *    php axiom migrations:sync-metadata-storage
 *    # Verifies migration tracking is properly initialized
 * 
 * 3. After manual schema changes:
 *    php axiom migrations:sync-metadata-storage
 *    # Re-synchronizes the migration history tracking
 */
class SyncMetadataCommand extends MigrationCommand
{
    /**
     * No validation needed as this command:
     * - Takes no arguments
     * - Requires no options
     * - Has no configuration parameters
     * 
     * @return array Empty array indicates no validation requirements
     */
    protected function validator(): array
    {
        return [];
    }

    /**
     * Specifies Doctrine's metadata synchronization command.
     * 
     * The 'migrations:sync-metadata-storage' command:
     * - Creates the migrations table if missing
     * - Updates the table structure if outdated
     * - Verifies all required columns exist
     * - Maintains version tracking integrity
     * 
     * @return string The Doctrine command identifier
     */
    protected function getMigrationCommandName(): string
    {
        return 'migrations:sync-metadata-storage';
    }

    /**
     * No input preparation needed because:
     * - The command requires no arguments
     * - It uses no configuration options
     * - All processing is handled internally by Doctrine
     * 
     * @return array Empty array as no input transformation is needed
     */
    protected function prepareInput(): array
    {
        return [];
    }

    /**
     * Executes the synchronization and provides clear feedback.
     * 
     * Typical Output:
     * - "Migration metadata storage synchronized successfully."
     * 
     * Error Cases:
     * - If database connection fails
     * - If table cannot be created/altered
     */
    public function handle(): void
    {
        parent::handle();
        $this->info('Migration metadata storage synchronized successfully.');
    }
}