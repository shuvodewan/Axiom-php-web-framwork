<?php

namespace Axiom\Messenger;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Configuration as DBALConfiguration;
use Symfony\Component\Messenger\Bridge\Doctrine\Transport\DoctrineTransportFactory;

class TransportFactoryLocator
{
    private ?Connection $doctrineConnection = null;
    private array $factories = [];
    private  $bus;

    public function __construct($bus)
    {
        $this->bus = $bus;
        $this->initializeDefaultFactories();
    }

    private function initializeDefaultFactories(): void
    {
        // Sync transport now receives the bus
        $this->addFactory('sync', new \Symfony\Component\Messenger\Transport\Sync\SyncTransportFactory($this->bus));
        
        // Other factories remain unchanged
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

        // Special handling for Doctrine
        if (str_starts_with($dsn, 'doctrine://')) {
            return $this->getDoctrineFactory();
        }

        throw new \RuntimeException("No transport factory found for DSN: $dsn");
    }

    private function getDoctrineFactory()
    {
        if (!isset($this->factories['doctrine'])) {
            $this->factories['doctrine'] = new DoctrineTransportFactory(
                $this->getDoctrineConnection()
            );
        }
        return $this->factories['doctrine'];
    }

    private function getDoctrineConnection()
    {
        if (!$this->doctrineConnection) {
            $this->doctrineConnection = DriverManager::getConnection(
                ['url' => env('DATABASE_URL')],
                new DBALConfiguration()
            );
        }
        return $this->doctrineConnection;
    }
}