<?php

namespace Axiom\Database\Relations;

use Axiom\Database\Builder;
use Doctrine\Common\Collections\ArrayCollection;
use RuntimeException;

class BelongsTo extends Relation
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
        $this->validateForeignKey();
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
        if (empty($this->mapping['joinColumns'])) {
            throw new RuntimeException(
                sprintf('BelongsTo relationship %s on %s requires joinColumns configuration',
                    $this->relationName,
                    get_class($this->parent)
                )
            );
        }
    }

    /**
     * Validate the foreign key exists and has a value
     *
     * @throws RuntimeException
     */
    protected function validateForeignKey(): void
    {
        $foreignKey = $this->mapping['joinColumns'][0]['name'];
        
        if (!method_exists($this->parent, 'get'.ucfirst($foreignKey))) {
            throw new RuntimeException(
                sprintf('Missing getter method for foreign key %s in %s',
                    $foreignKey,
                    get_class($this->parent)
                )
            );
        }
        
        if (null === $this->parent->{'get'.ucfirst($foreignKey)}()) {
            throw new RuntimeException(
                sprintf('Cannot query BelongsTo relationship %s - foreign key %s is null',
                    $this->relationName,
                    $foreignKey
                )
            );
        }
    }

    /**
     * Build the base query for the relationship
     */
    protected function buildBaseQuery(): void
    {
        $foreignKey = $this->mapping['joinColumns'][0]['name'];
        $foreignValue = $this->parent->{'get'.ucfirst($foreignKey)}();
        
        $this->queryBuilder
            ->select($this->relatedAlias)
            ->from($this->related, $this->relatedAlias)
            ->where("{$this->relatedAlias}.id = :foreign_id")
            ->setParameter('foreign_id', $foreignValue);
    }
}