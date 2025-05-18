<?php

namespace Axiom\Database\Relations;

use Axiom\Database\Builder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Abstract base class for entity relationships
 *
 * Provides core functionality for handling Doctrine ORM relationships
 * (OneToOne, OneToMany, ManyToOne, ManyToMany) with a fluent interface.
 */
abstract class Relation
{
    protected Builder $builder;
    protected object $parent;
    protected $mapping;
    protected string $related;
    protected string $relationName;
    protected QueryBuilder $queryBuilder;
    protected string $relatedAlias;
    protected EntityManager $entityManager;

    /**
     * @param Builder $builder The query builder instance
     * @param object $parent The parent entity instance
     * @param string $related The related entity class name
     * @param string $relationName The relationship name
     */
    public function __construct(
        Builder $builder,
        object $parent,
        string $related,
        string $relationName
    ) {
        $this->builder = $builder;
        $this->queryBuilder = $builder->getQueryBuilder();
        $this->entityManager = $builder->getEm();
        $this->parent = $parent;
        $this->related = $related;
        $this->relationName = $relationName;
        $this->relatedAlias = $this->createAlias();
        $this->mapping = $this->resolveMapping();

        $this->resetQueryBuilder();
        $this->initiate();
    }

    /**
     * Initialize the relationship query
     *
     * Concrete classes must implement this to define relationship-specific
     * query construction logic.
     */
    abstract public function initiate(): Builder;
    

    protected function resolveMapping()
    {
        /** @var ClassMetadata $metadata */
        $metadata = $this->entityManager
            ->getClassMetadata(get_class($this->parent));

        return $metadata->getAssociationMapping($this->relationName);
    }

    protected function resetQueryBuilder(): void
    {
        $this->queryBuilder->resetDQLParts(['select', 'from', 'where', 'join']);
    }

    protected function createAlias(): string
    {
        return 'r_' . substr(md5($this->relationName), 0, 8);
    }

    /**
     * Forward method calls to the underlying builder
     *
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function __call(string $method, array $args)
    {
        if (!method_exists($this->builder, $method)) {
            throw new \BadMethodCallException(
                sprintf('Method %s does not exist on %s', $method, get_class($this->builder))
            );
        }

        return $this->builder->$method(...$args);
    }

    /**
     * Configure the builder with relationship context
     */
    protected function configureBuilder(): void
    {
        $this->builder->entityClass = $this->related;
        $this->builder->alias = $this->relatedAlias;
    }

}