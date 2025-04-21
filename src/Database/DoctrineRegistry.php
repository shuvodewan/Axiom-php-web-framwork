<?php

namespace Axiom\Database;

use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ConnectionRegistry;

class DoctrineRegistry implements ConnectionRegistry
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getDefaultConnectionName(): string
    {
        return 'default';
    }

    public function getConnection($name = null): Connection
    {
        return $this->connection;
    }

    public function getConnections(): array
    {
        return ['default' => $this->connection];
    }

    public function getConnectionNames(): array { return ['default']; }
}