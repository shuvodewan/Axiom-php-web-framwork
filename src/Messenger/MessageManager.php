<?php

namespace Axiom\Messenger;

use App\Authentication\Transports\Handlers\MailHandler;
use App\Authentication\Transports\Jobs\MailJob;
use Symfony\Component\Messenger\{
    MessageBus,
    Envelope,
    Stamp\TransportNamesStamp,
    Stamp\DelayStamp
};
use Axiom\Application\AppManager;
use Psr\Container\ContainerInterface;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\Middleware\FailedMessageProcessingMiddleware;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\SendMessageMiddleware;
use Symfony\Component\Messenger\Transport\Sender\SendersLocator;

class MessageManager
{
    private $bus;
    public $transportManager;

    public function __construct()
    {
        $this->transportManager = new TransportManager(config('messenger'));
        $this->initializeBus();
    }

    private function initializeBus(): void
    {
        $middleware = [
            new FailedMessageProcessingMiddleware(),
            $this->createSendMessageMiddleware(),
            $this->createHandleMessageMiddleware()
        ];
        
        $this->bus = new MessageBus($middleware);
    }

    private function createSendMessageMiddleware(): MiddlewareInterface
    {
        return new SendMessageMiddleware(
            new SendersLocator(
                ['*' => [config('messenger.default_transport')]], 
                $this->createTransportContainer()
            )
        );
    }

    private function createHandleMessageMiddleware(): MiddlewareInterface
    {
    
        return new HandleMessageMiddleware(
            new HandlersLocator(AppManager::getInstance()->getJobs())
        );
    }

    private function createTransportContainer(): ContainerInterface
    {
        return new class($this->transportManager) implements ContainerInterface {
            private $transportManager;

            public function __construct($transportManager)
            {
                $this->transportManager = $transportManager;
            }

            public function get(string $id)
            {
                return $this->transportManager->getTransport($id);
            }

            public function has(string $id): bool
            {
                return array_key_exists($id, config('messenger.transports'));
            }
        };
    }
    

    public function dispatch(object $message, ?string $transport = null,?int $delayMs = null,array $stamps = []
    ): Envelope {
        if ($transport !== null) {
            $stamps[] = new TransportNamesStamp([$transport]);
        } elseif ($defaultName = config('messenger.default_transport')) {
            $stamps[] = new TransportNamesStamp([$defaultName]);
        }

        if ($delayMs !== null) {
            $stamps[] = new DelayStamp($delayMs);
        }

        return $this->bus->dispatch($message, $stamps);
    }

    /**
     * Get worker configuration
     */
    public function getWorkerConfig(): array
    {
        return $this->transportManager->getWorkerConfig();
    }

    /**
     * Get retry strategy configuration
     */
    public function getRetryStrategy(): array
    {
        return $this->transportManager->getRetryStrategy();
    }

    /**
     * Get the message bus instance
     */
    public function getBus(): MessageBus
    {
        return $this->bus;
    }

    /**
     * Get the transport manager instance
     */
    public function getTransportManager(): TransportManager
    {
        return $this->transportManager;
    }

    
}