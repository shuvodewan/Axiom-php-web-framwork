<?php

namespace Axiom\Messenger;

use Axiom\Database\DatabaseManager;
use Axiom\Database\DoctrineRegistry;
use Symfony\Component\Messenger\Bridge\Doctrine\Transport\DoctrineTransportFactory;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Transport\Serialization\PhpSerializer;

class TransportFactoryLocator
{
    private $registry = null;
    private array $factories = [];

    
    public function __construct()
    {
        $this->registry = new DoctrineRegistry(DatabaseManager::getInstance()->getConnection());
        $this->initializeDefaultFactories();
    }

    private function initializeDefaultFactories(): void
    {
        $this->addFactory('sync', new \Symfony\Component\Messenger\Transport\Sync\SyncTransportFactory(
            new MessageBus(),
            new PhpSerializer()
        ));
        
        $this->addFactory('amqp', new \Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpTransportFactory());
        $this->addFactory('redis', new \Symfony\Component\Messenger\Bridge\Redis\Transport\RedisTransportFactory());
        $this->addFactory('sqs', new \Symfony\Component\Messenger\Bridge\AmazonSqs\Transport\AmazonSqsTransportFactory());
    }

    public function addFactory(string $prefix, object $factory): void
    {
        $this->factories[$prefix] = $factory;
    }

    public function getFactory(string $dsn): object
    {
        foreach ($this->factories as $prefix => $factory) {
            if (str_starts_with($dsn, $prefix)) {
                return $factory;
            }
        }

        if (str_starts_with($dsn, 'doctrine://')) {
            return $this->getDoctrineFactory();
        }

        throw new \RuntimeException("No transport factory found for DSN: $dsn");
    }

    private function getDoctrineFactory()
    {
        if (!isset($this->factories['doctrine'])) {
            $this->factories['doctrine'] = new DoctrineTransportFactory(
                $this->registry
            );
        }
        return $this->factories['doctrine'];
    }

}