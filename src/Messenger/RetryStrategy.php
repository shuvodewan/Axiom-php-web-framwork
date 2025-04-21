<?php

namespace Axiom\Messenger;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Retry\RetryStrategyInterface;
use Symfony\Component\Messenger\Stamp\RedeliveryStamp;
use Throwable;

class RetryStrategy implements RetryStrategyInterface
{
    private int $maxRetries;
    private int $delayMilliseconds;
    private float $multiplier;
    private int $maxDelayMilliseconds;

    public function __construct(
        int $maxRetries = 3,
        int $delayMilliseconds = 1000,
        float $multiplier = 2,
        int $maxDelayMilliseconds = 10000
    ) {
        $this->maxRetries = $maxRetries;
        $this->delayMilliseconds = $delayMilliseconds;
        $this->multiplier = $multiplier;
        $this->maxDelayMilliseconds = $maxDelayMilliseconds;
    }

    public function isRetryable(Envelope $envelope, ?Throwable $throwable = null): bool
    {
        $retryCount = $this->getRetryCount($envelope);
        return $retryCount < $this->maxRetries;
    }

    public function getWaitingTime(Envelope $envelope, ?Throwable $throwable = null): int
    {
        $retryCount = $this->getRetryCount($envelope);
        $delay = (int) ($this->delayMilliseconds * pow($this->multiplier, $retryCount));
        
        return min($delay, $this->maxDelayMilliseconds);
    }

    private function getRetryCount(Envelope $envelope): int
    {
        /** @var RedeliveryStamp|null $redeliveryStamp */
        $redeliveryStamp = $envelope->last(RedeliveryStamp::class);
        return $redeliveryStamp ? $redeliveryStamp->getRetryCount() : 0;
    }
}