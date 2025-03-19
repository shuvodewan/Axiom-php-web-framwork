<?php

use Axiom\Application\AppManager;
use Axiom\Traits\InstanceTrait;
use Doctrine\DBAL\Connection as DBALConnection;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\ORMSetup;

class DatabaseManager
{
    use InstanceTrait;

    /**
     * Database connection configuration.
     *
     * @var array
     */
    protected array $connectionConfig = [];

    /**
     * Doctrine DBAL connection instance.
     *
     * @var DBALConnection
     */
    protected DBALConnection $connection;

    /**
     * Constructor.
     *
     * Initializes the database connection configuration and sets up the connection.
     */
    public function __construct()
    {
        $this->setConfig()->setConnection();
    }

    /**
     * Set the database connection configuration.
     *
     * @param array|null $config Custom database configuration. If null, uses the default configuration from the application.
     * @return self
     */
    private function setConfig(?array $config = null): self
    {
        $this->connectionConfig = $config ?? config('database.default', 'mysql');
        return $this;
    }

    /**
     * Set up the Doctrine DBAL connection.
     *
     * @return self
     */
    private function setConnection(): self
    {
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: (new AppManager())->getEntityDirs(), 
            isDevMode: true,
        );

        $this->connection = DriverManager::getConnection($this->connectionConfig, $config);

        return $this;
    }

    /**
     * Get the Doctrine DBAL connection instance.
     *
     * @return DBALConnection
     */
    public function getConnection(): DBALConnection
    {
        return $this->connection;
    }
}