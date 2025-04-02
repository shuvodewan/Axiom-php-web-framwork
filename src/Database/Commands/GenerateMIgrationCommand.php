<?php

namespace Axiom\Database\Commands;


class GenerateMigrationCommand extends MigrationCommand
{
    protected function validator(): array
    {
        return [
            'name' => 'required|string',
        ];
    }

    protected function getMigrationCommandName(): string
    {
        return 'migrations:generate';
    }

    protected function prepareInput(): array
    {
        return [
            'name' => $this->argument('name'),
            '--namespace' => 'Database\\Migrations', 
        ];
    }

    public function handle(): void
    {
        parent::handle();
        $this->info('MIgration created successfully.');
    }
}