<?php
// src/Transport/TransportManager.php

namespace Axiom\Messenger;

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
            // Normal case for other transports
            return $factory->createTransport(
                $transportConfig['dsn'],
                $transportConfig['options'] ?? []
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
}