<?php

namespace Axiom\Messenger;

use Symfony\Component\Messenger\Worker;
use Symfony\Component\Messenger\Worker\StopWhenMemoryUsageIsExceededWorker;
use Symfony\Component\Messenger\Worker\StopWhenTimeLimitIsReachedWorker;

class QueueWorker
{
    public function run(): void
    {
        $manager = new MessageManager();

        $receiver = $manager->getTransportManager()->getTransport(
            config('messenger.default_transport')
        );

        $bus = $manager->getBus();

        $worker = new Worker(
            [config('messenger.default_transport') => $receiver],
            $bus
        );

        // Optional: Add logging, signals, or limits
        $worker->run();
    }
}
