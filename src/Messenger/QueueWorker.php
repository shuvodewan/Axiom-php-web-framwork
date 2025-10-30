<?php

namespace Axiom\Messenger;

use Symfony\Component\Messenger\Worker;
use Symfony\Component\Messenger\EventListener\StopWorkerOnTimeLimitListener;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Messenger\EventListener\StopWorkerOnMemoryLimitListener;
use Symfony\Component\Messenger\Transport\Receiver\ReceiverInterface;
use Axiom\Application\AppManager;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;
use Symfony\Component\Messenger\Event\WorkerMessageHandledEvent;

class QueueWorker
{
    private $transportManager;
    private $logger;
    private $shouldStop = false;
    private $eventDispatcher;
    private $messageManager;

    public function __construct($logger = null)
    {
        $this->messageManager = new MessageManager();
        $this->transportManager = $this->messageManager->getTransportManager();
        $this->eventDispatcher = new EventDispatcher();
        $this->logger = $logger ?? $this->createSimpleLogger();
        $this->registerWorkerEventListeners();
    }

    private function createSimpleLogger()
    {
    
        return new class {
            public function log($level, $message, array $context = [])
            {
                $output = date('[Y-m-d H:i:s]') . " [$level] $message";
                if (!empty($context)) {
                    $output .= ' ' . json_encode($context);
                }
                $output .= PHP_EOL;
                
                echo $output;
                file_put_contents($this->getLogFilePath(), $output, FILE_APPEND);
            }
            
            private function getLogFilePath()
            {
                $dir = storage_path('/logs');
                if (!is_dir($dir)) {
                    mkdir($dir, 0755, true);
                }
                return $dir . '/worker.log';
            }
            
            public function emergency($message, array $context = []) { $this->log('emergency', $message, $context); }
            public function alert($message, array $context = []) { $this->log('alert', $message, $context); }
            public function critical($message, array $context = []) { $this->log('critical', $message, $context); }
            public function error($message, array $context = []) { $this->log('error', $message, $context); }
            public function warning($message, array $context = []) { $this->log('warning', $message, $context); }
            public function notice($message, array $context = []) { $this->log('notice', $message, $context); }
            public function info($message, array $context = []) { $this->log('info', $message, $context); }
            public function debug($message, array $context = []) { $this->log('debug', $message, $context); }
        };

    }

    public function work(array $options = []): void
    {
        $this->registerStopListeners($options);

        try {
            // Initialize the transport properly
            $transportName = $options['queue'] ?? config('messenger.default_transport');
            $this->transportManager->initializeTransport($transportName);
            
            $receiver = $this->transportManager->getReceiver($transportName);
            if (!$receiver instanceof ReceiverInterface) {
                throw new \RuntimeException(sprintf(
                    'Receiver for transport "%s" is not properly initialized',
                    $transportName
                ));
            }

            $worker = new Worker(
                [$transportName=>$receiver],
                $this->messageManager->getBus(),
                $this->eventDispatcher,
            );

            $this->registerSignalHandlers($worker);
            $worker->run([
                'sleep' => $options['sleep'] ?? 3,
            ]);

        } catch (\Throwable $e) {
            $this->logger->error('Worker error: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            if (!($options['once'] ?? false)) {
                sleep($options['rest'] ?? 1);
                if (!$this->shouldStop) {
                    $this->work($options);
                }
            }
        }
    }

    private function registerSignalHandlers(Worker $worker): void
    {
        if (extension_loaded('pcntl')) {
            declare(ticks=1);
            
            pcntl_signal(SIGTERM, function () use ($worker) {
                $this->shouldStop = true;
                $this->logger->info('Received SIGTERM signal, stopping worker...');
                $worker->stop();
                exit(0);
            });

            pcntl_signal(SIGINT, function () use ($worker) {
                $this->shouldStop = true;
                $this->logger->info('Received SIGINT signal, stopping worker...');
                $worker->stop();
                exit(0);
            });
        }
    }

    private function registerStopListeners(array $options): void
    {
        if (isset($options['max-runtime'])) {
            $this->eventDispatcher->addSubscriber(
                new StopWorkerOnTimeLimitListener($options['max-runtime'], $this->logger)
            );
        }

        if (isset($options['memory-limit'])) {
            $this->eventDispatcher->addSubscriber(
                new StopWorkerOnMemoryLimitListener($options['memory-limit'], $this->logger)
            );
        }
    }

    public function stop(): void
    {
        $this->shouldStop = true;
    }


    
private function registerWorkerEventListeners(): void
{
    $this->eventDispatcher->addListener(
        WorkerMessageHandledEvent::class,
        function (WorkerMessageHandledEvent $event) {
            $this->logger->info('Message handled successfully', [
                'message' => get_class($event->getEnvelope()->getMessage()),
            ]);
        }
    );

    $this->eventDispatcher->addListener(
        WorkerMessageFailedEvent::class,
        function (WorkerMessageFailedEvent $event) {
            $this->logger->error('Message handling failed', [
                'message' => get_class($event->getEnvelope()->getMessage()),
                'error' => $event->getThrowable()->getMessage(),
            ]);
        }
    );
}

}