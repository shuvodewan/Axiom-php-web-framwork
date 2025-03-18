<?php

namespace Axiom\Console\Commands;

use Axiom\Console\Command;

/**
 * AppServeCommand Class
 *
 * A console command for starting a PHP development server.
 * This command allows specifying the host and port for the server.
 */
class AppServeCommand extends Command
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
        $host = $this->argument('host') ?? 'localhost';
        $port = $this->argument('port') ?? 8008;

        $this->info('Starting PHP development server...');
        $command = "php -S $host:$port -t public";
        $this->info("Server running at http://$host:$port");

        exec($command);
        $this->info('Server started successfully.');
    }
}