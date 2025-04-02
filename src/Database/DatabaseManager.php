<?php

namespace Axiom\Database;

use App\Database\Builder;
use Axiom\Application\AppManager;
use Axiom\Traits\InstanceTrait;
use Doctrine\DBAL\Connection as DBALConnection;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

/**
 * DatabaseManager Class
 *
 * Central database management system that handles:
 * - Database connections
 * - Entity management
 * - Query builder initialization
 *
 * Uses singleton pattern via InstanceTrait to ensure single connection instance.
 */
class DatabaseManager
{
    use InstanceTrait;

    /** 
     * @var array Database connection configuration parameters 
     */
    protected array $connectionConfig;

    /** 
     * @var DBALConnection Doctrine DBAL connection instance 
     */
    protected DBALConnection $connection;

    /** 
     * @var EntityManager|null Doctrine ORM EntityManager instance (lazy-loaded) 
     */
    protected ?EntityManager $entityManager = null;

    /**
     * Constructor.
     * 
     * Initializes the database connection and configuration automatically.
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Initialize the database manager.
     * 
     * @return void
     */
    protected function initialize(): void
    {
        $this->connectionConfig = $this->resolveConfig();
        $this->connection = $this->createConnection();
    }

    /**
     * Resolve database configuration from application settings.
     * 
     * @return array
     * @throws \RuntimeException If configuration is not found
     */
    protected function resolveConfig(): array
    {
        return config('database.' . config('database.default')) ?? throw new \RuntimeException('Database configuration not found');
    }

    /**
     * Create a new DBAL connection.
     * 
     * @return DBALConnection
     */
    protected function createConnection(): DBALConnection
    {
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: (new AppManager())->getEntityDirs(),
            isDevMode: config('app.debug', true)
        );

        return DriverManager::getConnection($this->connectionConfig, $config);
    }

    /**
     * Get the DBAL connection instance.
     * 
     * @return DBALConnection
     */
    public function getConnection(): DBALConnection
    {
        return $this->connection;
    }

    /**
     * Get the EntityManager instance (lazy-loaded).
     * 
     * @return EntityManager
     */
    public function getEntityManager(): EntityManager
    {
        if (!$this->entityManager) {
            $this->entityManager = new EntityManager(
                $this->connection,
                ORMSetup::createAttributeMetadataConfiguration(
                    paths: (new AppManager())->getEntityDirs(),
                    isDevMode: config('app.debug', true)
                )
            );
        }
        return $this->entityManager;
    }

    /**
     * Create a new query builder for the specified entity.
     * 
     * @param string $entityClass The fully-qualified entity class name
     * @return Builder
     */
    public function builder(string $entityClass): Builder
    {
        return new Builder($this->getEntityManager(), $entityClass);
    }
}