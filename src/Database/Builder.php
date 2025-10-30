<?php

namespace Axiom\Database;

use Axiom\Database\Paginator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr\Join;

/**
 * Builder Class
 *
 * A fluent query builder for Doctrine ORM that provides an expressive syntax
 * for constructing database queries with proper type safety and parameter binding.
 */
class Builder
{
    /** @var QueryBuilder The underlying Doctrine QueryBuilder instance */
    protected QueryBuilder $queryBuilder;

    /** @var string The root alias used in the query */
    public string $alias;

      /** @var EntityManager The root alias used in the query */
      protected EntityManager $em;

    public $entityClass;   

    /** @var array Track of bound parameters */
    protected array $parameters = [];

    /**
     * Constructor.
     *
     * @param EntityManager $entityManager The Doctrine EntityManager
     * @param string $entityClass The fully-qualified entity class name
     * @param string $alias The alias to use for the root entity (default: 'e')
     */
    public function __construct(EntityManager $entityManager, string $entityClass, string $alias = 'e',$initiation=true)
    {
        $this->queryBuilder = $entityManager->createQueryBuilder();
        $this->em = $entityManager;
        $this->alias = $alias;
        $this->entityClass = $entityClass;
        if($initiation){
            $this->queryBuilder->select($alias)->from($entityClass, $alias);
        }
    }


    protected function setOperator(string &$column, string &$operator, &$value=null)
    {
        $column = $column;

        if (func_num_args() === 2) {
            $value = $operator;
            $operator = '=';
        }

        return $this;
    }

    /**
     * Add a basic WHERE clause to the query with Laravel-style syntax support.
     *
     * Supports multiple formats:
     * 1. where('column', 'value') - assumes = operator
     * 2. where('column', 'operator', 'value')
     * 3. where(['column' => 'value']) - assumes = operator
     * 4. where(['column' => ['operator', 'value']])
     * 
     * @param string|array $column Column name or array of conditions
     * @param mixed $operator Operator or value (when using 2-parameter syntax)
     * @param mixed $value The value to compare against (when using 3-parameter syntax)
     * @return $this
     */
    public function where($column, $operator = null, $value = null): self
    {
        if (is_array($column)) {
            foreach ($column as $key => $val) {
                if (is_array($val)) {
                    $this->addWhereCondition($key, $val[0], $val[1]);
                } else {
                    $this->addWhereCondition($key, '=', $val);
                }
            }
            return $this;
        }

        if (is_null($value)) {
            $value = $operator;
            $operator = '=';
        }

        $this->addWhereCondition($column, $operator, $value);
        
        return $this;
    }

    /**
     * Internal method to add a single where condition.
     * 
     * @param string $column
     * @param string $operator
     * @param mixed $value
     */
    protected function addWhereCondition(string $column, string $operator, $value): void
    {
        $param = $this->setOperator($column, $operator, $value)->createParameterName($column);
        $this->queryBuilder->andWhere("{$this->alias}.{$column} {$operator} :{$param}")
                        ->setParameter($param, $value);
    }

    /**
     * Add an OR WHERE clause to the query.
     *
     * @param string $column The column name
     * @param string $operator The comparison operator
     * @param mixed $value The value to compare against
     * @return $this
     */
    public function orWhere(string $column, string $operator, $value): self
    {
        $param = $this->setOperator($column, $operator, $value)->createParameterName($column);
        $this->queryBuilder->orWhere("{$this->alias}.{$column} {$operator} :{$param}")
                           ->setParameter($param, $value);
        return $this;
    }

    /**
     * Add a WHERE BETWEEN clause to the query.
     *
     * @param string $column The column name
     * @param mixed $min The minimum value
     * @param mixed $max The maximum value
     * @return $this
     */
    public function whereBetween(string $column, $min, $max): self
    {
        $minParam = $this->createParameterName($column.'_min');
        $maxParam = $this->createParameterName($column.'_max');
        
        $this->queryBuilder->andWhere("{$this->alias}.{$column} BETWEEN :{$minParam} AND :{$maxParam}")
                           ->setParameter($minParam, $min)
                           ->setParameter($maxParam, $max);
        return $this;
    }

    /**
     * Add a WHERE IN clause to the query.
     *
     * @param string $column The column name
     * @param array $values The array of values
     * @return $this
     */
    public function whereIn(string $column, array $values): self
    {
        $param = $this->createParameterName($column);
        $this->queryBuilder->andWhere("{$this->alias}.{$column} IN (:{$param})")
                           ->setParameter($param, $values);
        return $this;
    }

    /**
     * Add a WHERE NULL clause to the query.
     *
     * @param string $column The column name
     * @return $this
     */
    public function whereNull(string $column): self
    {
        $this->queryBuilder->andWhere("{$this->alias}.{$column} IS NULL");
        return $this;
    }

    /**
     * Add a JOIN clause to the query.
     *
     * @param string $relation The relationship to join
     * @param string $alias The alias for the joined entity
     * @param string $conditionType The join type (INNER_JOIN, LEFT_JOIN)
     * @param string|null $condition Additional join condition
     * @return $this
     */
    public function join(string $relation, string $alias, string $conditionType = Join::INNER_JOIN, ?string $condition = null): self
    {
        $this->queryBuilder->join("{$this->alias}.{$relation}", $alias, $conditionType, $condition);
        return $this;
    }

    /**
     * Add a GROUP BY clause to the query.
     *
     * @param string|array $columns The column(s) to group by
     * @return $this
     */
    public function groupBy($columns): self
    {
        if (is_array($columns)) {
            foreach ($columns as $column) {
                $this->queryBuilder->addGroupBy("{$this->alias}.{$column}");
            }
        } else {
            $this->queryBuilder->groupBy("{$this->alias}.{$columns}");
        }
        
        return $this;
    }

    /**
     * Eager load a relationship with optional callback for constraints.
     *
     * @param string $relation The relationship to load
     * @param string $alias The alias for the relationship
     * @param callable|null $callback Additional query constraints
     * @return $this
     */
    public function with(string $relation, string $alias, ?callable $callback = null): self
    {
        $this->join($relation, $alias, Join::LEFT_JOIN);
        $this->queryBuilder->addSelect($alias);

        if ($callback) {
            $callback(new self($this->queryBuilder->getEntityManager(), $relation, $alias));
        }

        return $this;
    }

    /**
     * Add a WHERE HAS clause to filter entities that have related records matching conditions.
     *
     * @param string $relation The relationship name
     * @param callable $callback A closure that receives a new Builder for the relation
     * @return $this
     */
    public function whereHas(string $relation, callable $callback): self
    {
        $relationAlias = $this->createRelationAlias($relation);
        $subBuilder = new self($this->queryBuilder->getEntityManager(), $relation, $relationAlias);
        
        $callback($subBuilder);
        
        // Get the DQL from the sub-builder
        $subQuery = $subBuilder->getQuery()->getDQL();
        
        // Add EXISTS condition to main query
        $this->queryBuilder->andWhere(
            $this->queryBuilder->expr()->exists($subQuery)
        );
        
        // Merge parameters from sub-query
        foreach ($subBuilder->getParameters() as $param => $value) {
            $this->queryBuilder->setParameter($param, $value);
        }
        
        return $this;
    }

    /**
     * Filter entities that have at least one related record (simple HAS condition).
     *
     * @param string $relation The relationship name
     * @return $this
     */
    public function has(string $relation): self
    {
        $relationAlias = $this->createRelationAlias($relation);
        $this->queryBuilder->innerJoin("{$this->alias}.{$relation}", $relationAlias);
        return $this;
    }

    /**
     * Add a WHERE DOESN'T HAVE clause to filter entities without related records matching conditions.
     *
     * @param string $relation The relationship name
     * @param callable|null $callback Optional conditions for the relation
     * @return $this
     */
    public function whereDoesntHave(string $relation, ?callable $callback = null): self
    {
        $relationAlias = $this->createRelationAlias($relation);
        $subBuilder = new self($this->queryBuilder->getEntityManager(), $relation, $relationAlias);
        
        if ($callback) {
            $callback($subBuilder);
        }
        
        $subQuery = $subBuilder->getQuery()->getDQL();
        
        $this->queryBuilder->andWhere(
            $this->queryBuilder->expr()->not(
                $this->queryBuilder->expr()->exists($subQuery)
            )
        );
        
        foreach ($subBuilder->getParameters() as $param => $value) {
            $this->queryBuilder->setParameter($param, $value);
        }
        
        return $this;
    }

    /**
     * Get all bound parameters from the query builder.
     */
    protected function getParameters(): array
    {
        return $this->queryBuilder->getParameters()->toArray();
    }

    /**
     * Create a unique alias for a relationship.
     */
    protected function createRelationAlias(string $relation): string
    {
        return 'r_' . substr(md5($relation), 0, 8);
    }

    /**
     * Add an ORDER BY clause to the query.
     *
     * @param string $column The column to order by
     * @param string $direction The sort direction (ASC|DESC)
     * @return $this
     */
    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $this->queryBuilder->orderBy("{$this->alias}.{$column}", $direction);
        return $this;
    }

    /**
     * Set the maximum number of results to return.
     *
     * @param int $value The maximum number of results
     * @return $this
     */
    public function limit(int $value): self
    {
        $this->queryBuilder->setMaxResults($value);
        return $this;
    }

    /**
     * Set the offset for the query results.
     *
     * @param int $value The number of results to skip
     * @return $this
     */
    public function offset(int $value): self
    {
        $this->queryBuilder->setFirstResult($value);
        return $this;
    }

    /**
     * Set the limit and offset for a paginated query.
     *
     * @param int $page The page number (1-based)
     * @param int $perPage The number of items per page
     * @return $this
     */
    public function paginate(int $perPage = 15,$page='page', int $currentPage = 1, ): Paginator
    {
        return Paginator::fromQueryBuilder( $this->queryBuilder, $perPage, $currentPage, $page);
    }

    /**
     * Get the underlying Doctrine Query object.
     *
     * @return \Doctrine\ORM\Query
     */
    public function getQuery(): \Doctrine\ORM\Query
    {
        return $this->queryBuilder->getQuery();
    }

    /**
     * Execute the query and get all results.
     *
     * @return array
     */
    public function get(): ArrayCollection
    {
        $results = $this->getQuery()->getResult();
        return new ArrayCollection($results);
    }

    /**
     * Execute the query and get the first result.
     *
     * @return object|null
     */
    public function first(): ?object
    {
        return $this->limit(1)->getQuery()->getOneOrNullResult();
    }

    /**
     * Get the count of records matching the query.
     *
     * @return int
     */
    public function count(): int
    {
        $countQuery = clone $this->queryBuilder;
        $countQuery->select("COUNT({$this->alias})");
        return (int) $countQuery->getQuery()->getSingleScalarResult();
    }

    /**
     * Get the SQL string for the query.
     *
     * @return string
     */
    public function toSql(): string
    {
        return $this->getQuery()->getSQL();
    }

    /**
     * Handle dynamic method calls.
     *
     * @param string $method The method name
     * @param array $args The method arguments
     * @return mixed
     * @throws \BadMethodCallException
     */
    public function __call(string $method, array $args)
    {
        $scopeMethod = 'scope' . ucfirst($method);
        $entityClass = $this->queryBuilder->getRootEntities()[0];
        
        if (method_exists($entityClass, $scopeMethod)) {
            $entity = new $entityClass();
            $entity->$scopeMethod($this, ...$args);
            
            return $this;
        }

        throw new \BadMethodCallException(sprintf(
            'Method %s::%s does not exist', 
            static::class,
            $method
        ));
    }

    /**
     * Create a unique parameter name for binding.
     *
     * @param string $column The column name to base the parameter on
     * @return string
     */
    protected function createParameterName(string $column): string
    {
        return str_replace(['.', ' '], '_', uniqid($column.'_'));
    }

    
    /**
     * Filter entity from the database
     *
     * @return self
     */
   public function filters(array $params): self
    {
        foreach ($params as $method => $paramValue) {
            $scopeMethod = 'scope' . ucfirst($method);
            $entityClass = $this->queryBuilder->getRootEntities()[0];
            
            if (!method_exists($entityClass, $scopeMethod)) {
                throw new \BadMethodCallException(sprintf(
                    'Scope method %s::%s does not exist', 
                    $entityClass,
                    $scopeMethod
                ));
            }

            (new $entityClass())->$scopeMethod($this, $paramValue);
        }
        
        return $this;
    }


    /**
     * Get the underlying Doctrine QueryBuilder instance
     * 
     * @return QueryBuilder The Doctrine QueryBuilder instance
     */
    public function getQueryBuilder(): QueryBuilder
    {
        return $this->queryBuilder;
    }

    /**
     * Get the EntityManager instance associated with this builder
     * 
     * @return EntityManager The Doctrine EntityManager instance
     */
    public function getEm(): EntityManager
    {
        return $this->em;
    }
}