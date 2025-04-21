<?php

namespace Axiom\Messenger\Commands;

use Axiom\Console\Command;
use Axiom\Messenger\QueueWorker;

/**
 * AppServeCommand Class
 *
 * A console command for starting a PHP development server.
 * This command allows specifying the host and port for the server.
 */
class WorkerCommand extends Command
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
        (new QueueWorker())->run();
    }
}