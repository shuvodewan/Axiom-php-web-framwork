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
     * Get em instance.
     * 
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getEntityManager()
    {
        return $this->entityManager;
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
     * Execute a callback within a transaction.
     *
     * @param callable $callback
     * @return mixed
     * @throws \Throwable
     */
    public function transaction(callable $callback)
    {
        $this->begin();
        try {
            $result = $callback();
            $this->commit();
            return $result;
        } catch (\Throwable $e) {
            $this->rollback();
            throw $e;
        }
    }

    /**
     * Persist an entity (optionally flush immediately).
     *
     * @param object $entity
     * @param bool $flush Whether to flush immediately
     * @return void
     */
    public function persist(object $entity, bool $flush = true): void
    {
        if (!$this->entityManager->contains($entity) && !$this->entityManager->getMetadataFactory()->isTransient(get_class($entity))) {
            throw new \InvalidArgumentException('Entity is not manageable by this EntityManager');
        }

        $this->entityManager->persist($entity);
        if ($flush) {
            $this->flush();
        }
    }

    /**
     * Persist multiple entities with single flush
     * 
     * @param object[] $entities
     * @param bool $flush Whether to flush immediately
     */
    public function persistAll(array $entities, bool $flush = true): void
    {
        foreach ($entities as $entity) {
            $this->persist($entity, false);
        }
        if ($flush) {
            $this->flush();
        }
    }

    /**
     * Remove an entity (optionally flush immediately).
     *
     * @param object $entity
     * @param bool $flush Whether to flush immediately
     * @return void
     */
    public function remove(object $entity, bool $flush = true): void
    {
        $this->entityManager->remove($entity);
        if ($flush) {
            $this->flush();
        }
    }

    /**
     * Flush all pending changes to the database.
     *
     * @return void
     */
    public function flush(): void
    {
        $this->entityManager->flush();
    }

    /**
     * Refresh an entity state from the database.
     *
     * @param object $entity
     * @return void
     */
    public function refresh(object $entity): void
    {
        $this->entityManager->refresh($entity);
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