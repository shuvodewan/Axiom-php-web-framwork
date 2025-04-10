<?php

namespace Axiom\Database\Commands;

class VersionCommand extends MigrationCommand
{
    protected function validator(): array
    {
        return [
            'version' => 'required|string',
        ];
    }

    protected function getMigrationCommandName(): string
    {
        return 'migrations:version';
    }

    protected function prepareInput(): array
    {
        return [
            'version' => $this->argument('version'),
            '--add' => $this->argument('add') ?: false,
            '--delete' => $this->argument('delete') ?: false,
        ];
    }

    public function handle(): void
    {
        parent::handle();
        $this->info('Version operation completed.');
    }
}