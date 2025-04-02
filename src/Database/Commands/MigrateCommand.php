<?php

namespace Axiom\Database\Commands;

class MigrateCommand extends MigrationCommand
{
    protected function validator(): array
    {
        return [
            'version' => 'nullable|string',
            '--dry-run' => 'nullable|boolean',
            '--query-time' => 'nullable|boolean',
            '--allow-no-migration' => 'nullable|boolean',
        ];
    }

    protected function getMigrationCommandName(): string
    {
        return 'migrations:migrate';
    }

    protected function prepareInput(): array
    {
        $input = [];

        if ($version = $this->argument('version')) {
            $input['version'] = $version;
        }

        if ($this->argument('--dry-run')) {
            $input['--dry-run'] = true;
        }

        if ($this->argument('--query-time')) {
            $input['--query-time'] = true;
        }

        if ($this->argument('--allow-no-migration')) {
            $input['--allow-no-migration'] = true;
        }

        return $input;
    }

    public function handle(): void
    {
        parent::handle();
        $this->info('migrate completed successfully.');
    }
}