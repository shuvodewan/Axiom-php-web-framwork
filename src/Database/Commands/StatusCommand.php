<?php

namespace Axiom\Database\Commands;


class StatusCommand extends MigrationCommand
{

    protected function validator(): array
    {
        return [];
    }

    protected function getMigrationCommandName(): string
    {
        return 'migrations:status';
    }

    protected function prepareInput(): array
    {
        return [];
    }
}