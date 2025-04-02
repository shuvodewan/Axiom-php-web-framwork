<?php

namespace Axiom\Database\Commands;

class RollbackCommand extends MigrationCommand
{
    protected function validator(): array
    {
        return [
            '--dry-run' => 'boolean|optional',
            '--query-time' => 'boolean|optional',
            '--all' => 'boolean|optional',
            '--force' => 'boolean|optional',
        ];
    }

    protected function getMigrationCommandName(): string
    {
        return 'migrations:rollup'; // or 'migrations:execute --down' for more control
    }

    protected function prepareInput(): array
    {
        $input = [];

        if ($this->argument('--dry-run')) {
            $input['--dry-run'] = true;
        }

        if ($this->argument('--query-time')) {
            $input['--query-time'] = true;
        }

        if ($this->argument('--all')) {
            $input['--all'] = true;
        }

        if ($this->argument('--force')) {
            $input['--force'] = true;
        }

        return $input;
    }

    public function handle(): void
    {
        parent::handle();
        $this->info('Rollback completed successfully.');
    }
}