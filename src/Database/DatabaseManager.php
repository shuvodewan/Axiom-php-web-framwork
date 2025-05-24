<?php

namespace Axiom\Database;

use Axiom\Application\AppManager;
use Axiom\Traits\InstanceTrait;
use Doctrine\DBAL\Connection as DBALConnection;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Configuration;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use RuntimeException;
use PDO;

/**
 * DatabaseManager - Central database management system
 * 
 * Handles database connections, entity management, and query building using Doctrine ORM.
 * Implements singleton pattern via InstanceTrait to ensure single connection instance.
 */
class DatabaseManager
{
    use InstanceTrait;

    /** 
     * @var array<string, mixed> Database connection configuration parameters 
     */
    protected array $connectionConfig;

    /** 
     * @var DBALConnection Active Doctrine DBAL connection instance 
     */
    protected DBALConnection $connection;

    /** 
     * @var EntityManager|null Doctrine ORM EntityManager instance (lazy-loaded) 
     */
    protected ?EntityManager $entityManager = null;

    /** 
     * @var Configuration|null Doctrine ORM configuration instance 
     */
    protected ?Configuration $ormConfig = null;

    /**
     * Constructor - Initializes the database connection automatically
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Initialize the database manager components
     * 
     * @return void
     */
    protected function initialize(): void
    {
        $this->connectionConfig = $this->resolveConfig();
        $this->ormConfig = $this->createOrmConfig();
        $this->connection = $this->createConnection();
    }

    /**
     * Resolve database configuration from application settings
     * 
     * @return array<string, mixed>
     * @throws RuntimeException If database configuration is not found
     */
    protected function resolveConfig(): array
    {
        $config = config('database.connections.' . config('database.default'));
        
        if (empty($config)) {
            throw new RuntimeException('Database configuration not found');
        }

        return array_merge([
            'charset' => 'utf8mb4',
            'driverOptions' => [
                PDO::ATTR_STRINGIFY_FETCHES => false,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ],
            'defaultTableOptions' => [
                'charset' => 'utf8mb4',
                'collate' => 'utf8mb4_unicode_ci',
            ]
        ], $config);
    }

    /**
     * Create Doctrine ORM configuration
     * 
     * @return Configuration
     */
    protected function createOrmConfig(): Configuration
    {
        return ORMSetup::createAttributeMetadataConfiguration(
            paths: (new AppManager())->getEntityDirs(),
            isDevMode: config('app.debug', true),
            proxyDir: storage_path('/doctrine/proxies'),
            cache: $this->createCacheInstance()
        );
    }

    /**
     * Create cache instance for Doctrine metadata
     * 
     * @return ArrayAdapter
     */
    protected function createCacheInstance(): ArrayAdapter
    {
        return new ArrayAdapter();
    }

    /**
     * Create DBAL connection instance
     * 
     * @return DBALConnection
     */
    protected function createConnection(): DBALConnection
    {
        return DriverManager::getConnection(
            $this->connectionConfig,
            $this->ormConfig
        );
    }

    /**
     * Get active DBAL connection instance
     * 
     * @return DBALConnection
     */
    public function getConnection(): DBALConnection
    {
        return $this->connection;
    }

    /**
     * Get EntityManager instance (lazy-loaded)
     * 
     * @return EntityManager
     */
    public function getEntityManager(): EntityManager
    {
        if (!$this->entityManager) {
            $this->entityManager = new EntityManager(
                $this->connection,
                $this->ormConfig
            );
        }
        return $this->entityManager;
    }

    /**
     * Create a new query builder for the specified entity
     * 
     * @param class-string $entityClass Fully-qualified entity class name
     * @return Builder
     */
    public function builder(string $entityClass): Builder
    {
        return new Builder($this->getEntityManager(), $entityClass);
    }

    /**
     * Check if database connection is active
     * 
     * @return bool True if connection is active, false otherwise
     */
    public function isConnected(): bool
    {
        try {
            $this->connection->connect();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Disconnect from the database
     * 
     * @return void
     */
    public function disconnect(): void
    {
        if ($this->connection->isConnected()) {
            $this->connection->close();
        }
    }

    /**
     * Destructor - Ensures connection is closed when object is destroyed
     */
    public function __destruct()
    {
        $this->disconnect();
    }
}