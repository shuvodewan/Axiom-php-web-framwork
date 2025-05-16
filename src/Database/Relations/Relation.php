<?php

namespace Axiom\Database\Relations;

use Axiom\Database\Builder;
use Doctrine\ORM\QueryBuilder;

/**
 * Abstract base class for entity relationships
 *
 * Provides core functionality for handling different types of entity relationships
 * (OneToOne, OneToMany, ManyToOne, ManyToMany) with Doctrine ORM.
 */
abstract class Relation
{
    /** @var Builder The query builder instance */
    protected $builder;
    
    /** @var object The parent entity instance */
    protected $parent;

    /** @var array The Doctrine association mapping metadata */
    protected $mapping;
    
    /** @var string The fully qualified related entity class name */
    protected $related;
    
    /** @var string The relationship name as defined in the entity */
    protected $relationName;
    
    /** @var QueryBuilder The Doctrine QueryBuilder instance */
    protected $queryBuilder;
    
    /** @var string The alias used for the related entity in queries */
    protected $relatedAlias;

    /**
     * Relation constructor
     *
     * @param Builder $builder The query builder instance
     * @param object $parent The parent entity instance
     * @param string $related The related entity class name
     * @param string $relationName The relationship name
     */
    public function __construct(Builder $builder, $parent, string $related, string $relationName)
    {
        $this->builder = $builder;
        $this->queryBuilder = $builder->getQueryBuilder();
        $this->parent = $parent;
        $this->related = $related;
        $this->relationName = $relationName;
        $this->relatedAlias = $this->createAlias();

        // Get Doctrine metadata for the parent entity
        $metadata = $builder->getEm()->getClassMetadata(get_class($this->parent));
        $this->mapping = $metadata->getAssociationMapping($this->relationName);

        // Clear existing query parts to start fresh
        $this->queryBuilder->resetDQLParts(['select', 'from', 'where']);
        


        $this->initiate();    
    }

    /**
     * Execute the relationship query and get results
     *
     * Concrete relationship classes must implement this method to define
     * how the relationship should be queried and results returned.
     *
     * @return mixed The relationship query results
     */
    abstract public function initiate();

    /**
     * Create a unique alias for the related entity in queries
     *
     * Generates a consistent alias based on the relationship name to avoid
     * collisions when joining multiple relationships.
     *
     * @return string The generated alias
     */
    protected function createAlias(): string
    {
        return 'r_' . substr(md5($this->relationName), 0, 8);
    }

    /**
     * Handle dynamic method calls
     *
     * Proxies method calls to the underlying query builder instance,
     * allowing for fluent query construction on relationships.
     *
     * @param string $method The method name
     * @param array $args The method arguments
     * @return mixed
     */
    protected function __call($method, $args)
    {
        return $this->builder->$method(...$args);
    }
}