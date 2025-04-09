<?php

namespace Axiom\Database\Commands;

class LatestCommand extends MigrationCommand
{

    protected function validator(): array
    {
        return [];
    }

    protected function getMigrationCommandName(): string
    {
        return 'migrations:latest';
    }

    protected function prepareInput(): array
    {
        return [];
    }
}