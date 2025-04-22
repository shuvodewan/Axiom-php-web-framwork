<?php

namespace Axiom\Messenger\Commands;

use Axiom\Console\Command;
use Axiom\Messenger\QueueWorker;
use Exception;

class WorkerCommand extends Command
{
    /**
     * Handle the command execution.
     *
     * @return void
     */
    public function handle(): void
    {
        $worker = new QueueWorker();
        
        $options = [
            'queue' => $this->argument('queue'),
            'sleep' => $this->argument('sleep') ?? 3,
            'once' => $this->argument('once') ?? false,
            'stop-when-empty' => $this->argument('stop-when-empty') ?? false,
            'max-runtime' => $this->argument('max-runtime') ? (int)$this->argument('max-runtime') : null,
            'memory-limit' => $this->argument('memory-limit') ? (int)$this->argument('memory-limit') : null,
        ];

        $worker->work($options);
    }

    /**
     * Define validation rules for command arguments.
     *
     * @return array The validation rules
     */
    protected function validator(): array
    {
        return [
            'queue' => 'nullable|string',
            'sleep' => 'nullable|numeric',
            'once' => 'nullable|boolean',
            'stop-when-empty' => 'nullable|boolean',
            'max-runtime' => 'nullable|numeric',
            'memory-limit' => 'nullable|numeric',
        ];
    }

    /**
     * Get the command description.
     *
     * @return string
     */
    public static function getDescription(): string
    {
        return 'Process messages from the queue';
    }

    /**
     * Get the command help text.
     *
     * @return string
     */
    public static function getHelp(): string
    {
        return <<<HELP
        Process messages from the specified queue.

        Options:
        --queue=NAME          The queue to consume from
        --sleep=SECONDS       Seconds to sleep when no message is found (default: 3)
        --once                Only process one message
        --stop-when-empty     Stop when the queue is empty
        --max-runtime=SECONDS Maximum time in seconds the worker will run
        --memory-limit=MB     Memory limit in MB the worker can consume
        HELP;
    }
}