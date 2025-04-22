<?php
// src/Transport/TransportManager.php

namespace Axiom\Messenger;

use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Transport\Receiver\ReceiverInterface;
use Symfony\Component\Messenger\Transport\Serialization\PhpSerializer;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Messenger\Transport\Sync\SyncTransportFactory;
use Symfony\Component\Messenger\Transport\TransportInterface;

class TransportManager
{
    private array $transports = [];

    private TransportFactoryLocator $factoryLocator;
    
    public function __construct(private array $config) {
        $this->factoryLocator = new TransportFactoryLocator();
    }
    
    public function getTransport(string $name): TransportInterface
    {
        if (!isset($this->transports[$name])) {
            $this->transports[$name] = $this->createTransport($name);
        }
        return $this->transports[$name];
    }
    
    public function getDefaultTransport(): TransportInterface
    {
        return $this->getTransport($this->config['default_transport']);
    }
    
        private function createTransport(string $name): TransportInterface
        {
            if (!isset($this->config['transports'][$name])) {
                throw new \RuntimeException("Transport '$name' not configured");
            }
            
            $transportConfig = $this->config['transports'][$name];
            $factory = $this->factoryLocator->getFactory($transportConfig['dsn']);
            return $factory->createTransport(
                $transportConfig['dsn'],
                $transportConfig['options'] ?? [],
                $this->getSyncSerializer() 
            );
            
        }
    
        private function getSyncSerializer(): SerializerInterface
        {
            return new PhpSerializer();
        }
    
    public function getRetryStrategy(): array
    {
        return $this->config['retry_strategy'] ?? [];
    }
    
    public function getWorkerConfig(): array
    {
        return $this->config['worker'] ?? [];
    }

    public function initializeTransport(string $transportName): void
    {
        if (!isset($this->transports[$transportName])) {
            $this->transports[$transportName] = $this->createTransport($transportName);
        }
    }
    
    public function getReceiver(string $transportName): ReceiverInterface
    {
        $transport = $this->getTransport($transportName);
        // Some transports implement ReceiverInterface directly
        if ($transport instanceof ReceiverInterface) {
            return $transport;
        }
        // Standard Symfony transports have a get() method
        $receiver = $transport->get();
        
        if (!$receiver instanceof ReceiverInterface) {
            throw new \RuntimeException(sprintf(
                'Receiver for transport "%s" must implement %s, %s given',
                $transportName,
                ReceiverInterface::class,
                is_object($receiver) ? get_class($receiver) : gettype($receiver)
            ));
        }
        
        return $receiver;
    }
}