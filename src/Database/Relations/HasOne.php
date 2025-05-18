<?php

namespace Axiom\Database\Relations;

use Axiom\Database\Builder;
use Doctrine\Common\Collections\ArrayCollection;
use RuntimeException;

class HasOne extends Relation
{
    /**
     * Initialize the relationship query
     *
     * @return Builder
     * @throws RuntimeException
     */
    public function initiate(): Builder
    {
        $this->validateMapping();
        $this->buildBaseQuery();
        $this->configureBuilder();
        
        return $this->builder;
    }

    /**
     * Validate the relationship mapping configuration
     *
     * @throws RuntimeException
     */
    protected function validateMapping(): void
    {
        if (!isset($this->mapping['mappedBy']) && 
            !isset($this->mapping['joinColumns'][0]['name'])) {
            throw new RuntimeException(
                sprintf('HasOne relationship %s on %s requires either mappedBy or joinColumns',
                    $this->relationName,
                    get_class($this->parent)
                )
            );
        }
    }

    /**
     * Build the base query for the relationship
     */
    protected function buildBaseQuery(): void
    {
        $this->queryBuilder
            ->select($this->relatedAlias)
            ->from($this->related, $this->relatedAlias)
            ->setMaxResults(1);

        if (isset($this->mapping['mappedBy'])) {
            $this->buildMappedByQuery();
        } else {
            $this->buildJoinColumnsQuery();
        }
    }

    /**
     * Build query for mappedBy relationships
     *
     * @throws RuntimeException
     */
    protected function buildMappedByQuery(): void
    {
        if (!$this->parent->getId()) {
            throw new RuntimeException(
                sprintf('Cannot query HasOne relationship %s - parent entity %s is unsaved',
                    $this->relationName,
                    get_class($this->parent))
            );
        }

        $this->queryBuilder
            ->andWhere("{$this->relatedAlias}.{$this->mapping['mappedBy']} = :parent_id")
            ->setParameter('parent_id', $this->parent->getId());
    }

    /**
     * Build query for joinColumns relationships
     *
     * @throws RuntimeException
     */
    protected function buildJoinColumnsQuery(): void
    {
        $foreignKey = $this->mapping['joinColumns'][0]['name'];
        
        if (!method_exists($this->parent, 'get' . ucfirst($foreignKey))) {
            throw new RuntimeException(
                sprintf('Missing getter method for foreign key %s in %s',
                    $foreignKey,
                    get_class($this->parent))
            );
        }

        $foreignValue = $this->parent->{'get' . ucfirst($foreignKey)}();
        
        if ($foreignValue === null) {
            throw new RuntimeException(
                sprintf('Foreign key value cannot be null for HasOne relationship %s',
                    $this->relationName)
            );
        }

        $this->queryBuilder
            ->andWhere("{$this->relatedAlias}.id = :foreign_id")
            ->setParameter('foreign_id', $foreignValue);
    }

}