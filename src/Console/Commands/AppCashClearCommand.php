<?php

namespace Axiom\Console\Commands;

use Axiom\Console\Command;
use Axiom\Facade\Cache;

/**
 * AppCashClearCommand Class
 *
 * A console command for clearing application cache.
 * This command clears the cache stored in the 'service' subdirectory.
 */
class AppCashClearCommand extends Command
{
    /**
     * Define validation rules for command arguments.
     *
     * @return array The validation rules
     */
    protected function validator(): array
    {
        return [];
    }

    /**
     * Handle the command execution.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->info('Clearing application cache...');
        $this->info('');

        Cache::setSubDir('service')->clear();

        $this->info('Application cache cleared successfully.');
    }
}