<?php

namespace Axiom\Messenger\Commands;

use Axiom\Console\Command;
use Axiom\Messenger\MessageManager;
use Symfony\Component\Messenger\Transport\Receiver\ListableReceiverInterface;

class ListFailedJobsCommand extends Command
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
        $receiver = (new MessageManager())->getTransportManager()->getTransport('failed');

        if (!$receiver instanceof ListableReceiverInterface) {
            $this->output('This transport does not support listing failed messages.');
            return;
        }

        foreach ($receiver->all() as $envelope) {
            $message = $envelope->getMessage();
            $this->output("Failed Message: " . get_class($message));
        }
    }
}
