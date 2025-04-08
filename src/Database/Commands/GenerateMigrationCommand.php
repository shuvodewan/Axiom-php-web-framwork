<?php

namespace Axiom\Database\Commands;

use Symfony\Component\Console\Input\InputArgument;

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
            '--namespace' => 'Database\\Migrations',
        ];
    }

    public function handle(): void
    {
        parent::handle();
        $this->info('Migration created successfully.');
    }
}