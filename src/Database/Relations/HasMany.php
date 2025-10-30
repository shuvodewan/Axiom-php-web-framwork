<?php

namespace Axiom\Database\Relations;

use Axiom\Database\Builder;
use Doctrine\Common\Collections\ArrayCollection;
use RuntimeException;

class HasMany extends Relation
{
    /**
     * Initialize the relationship query
     */
    public function initiate(): Builder
    {
        $this->validateMapping();
        $this->validateParent();
        $this->buildBaseQuery();
        $this->configureBuilder();
        
        return $this->builder;
    }

    protected function validateMapping(): void
{
    if (empty($this->mapping['mappedBy'])) {
        throw new RuntimeException(
            sprintf('HasMany relationship %s on %s requires mappedBy',
            $this->relationName, 
            get_class($this->parent))
        );
    }
}

    protected function validateParent(): void
    {
        if ($this->parent->getId() === null) {
            throw new RuntimeException(
                sprintf('Cannot query unsaved parent in %s::%s',
                    get_class($this->parent),
                    $this->relationName
                )
            );
        }
    }

    protected function buildBaseQuery(): void
    {
        $this->queryBuilder
            ->select($this->relatedAlias)
            ->from($this->related, $this->relatedAlias)
            ->where("{$this->relatedAlias}.{$this->mapping['mappedBy']} = :parent_id")
            ->setParameter('parent_id', $this->parent->getId());
    }
}