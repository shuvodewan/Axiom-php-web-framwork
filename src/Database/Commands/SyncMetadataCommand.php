<?php

namespace Axiom\Database\Commands;


class SyncMetadataCommand extends MigrationCommand
{

    protected function validator(): array
    {
        return [
           
        ];
    }

    protected function getMigrationCommandName(): string
    {
        return 'migrations:sync-metadata-storage';
    }

    protected function prepareInput(): array
    {
        return [];
    }

    public function handle(): void
    {
        parent::handle();
        $this->info('Metadata storage synchronized.');
    }
}