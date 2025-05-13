<?php

namespace Axiom\Database;

use Axiom\Traits\InstanceTrait;
use Doctrine\ORM\EntityManager;

/**
 * Database handler class providing a simplified interface for Doctrine operations
 * with transaction support and query building capabilities.
 */
class DB
{
    use InstanceTrait;

    /**
     * @var EntityManager Doctrine Entity Manager instance
     */
    public $entityManager;

    /**
     * DB constructor.
     * Initializes the Doctrine EntityManager through the DatabaseManager.
     */
    public function __construct()
    {
        $this->entityManager = DatabaseManager::getInstance()->getEntityManager();
    }

    /**
     * Creates and returns a new Doctrine QueryBuilder instance.
     * 
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function query()
    {
        return $this->entityManager->createQueryBuilder();
    }

    /**
     * Starts a database transaction.
     */
    public function begin()
    {
        $this->entityManager->beginTransaction();
    }

    /**
     * Rolls back the current transaction.
     */
    public function rollback()
    {
        if ($this->entityManager->getConnection()->isTransactionActive()) {
            $this->entityManager->rollback();
        }
    }

    /**
     * Commits the current transaction.
     */
    public function commit()
    {
        if ($this->entityManager->getConnection()->isTransactionActive()) {
            $this->entityManager->commit();
        }
    }

    /**
     * Shortcut method to get a repository for the specified entity class.
     *
     * @param string $entityClass The entity class name
     * @return \Doctrine\ORM\EntityRepository
     */
    public function repository($entityClass)
    {
        return $this->entityManager->getRepository($entityClass);
    }
}