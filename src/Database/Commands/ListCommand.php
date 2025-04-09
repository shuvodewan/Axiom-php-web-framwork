<?php

namespace Axiom\Database\Commands;

class ListCommand extends MigrationCommand
{

    protected function validator(): array
    {
        return [];
    }

    protected function getMigrationCommandName(): string
    {
        return 'migrations:list';
    }

    protected function prepareInput(): array
    {
        return [];
    }
}