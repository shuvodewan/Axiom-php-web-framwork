<?php

namespace Axiom\Database\Relations;

use Axiom\Database\Builder;
use Doctrine\Common\Collections\ArrayCollection;
use RuntimeException;

class BelongsToMany extends Relation
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
        $this->validateParent();
        $this->prepareQueryBuilder();
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
        if (!isset($this->mapping['inversedBy']) && !isset($this->mapping['mappedBy'])) {
            throw new RuntimeException(
                sprintf('BelongsToMany relationship %s on %s requires either inversedBy or mappedBy',
                    $this->relationName,
                    get_class($this->parent)
                )
            );
        }
    }

    /**
     * Validate the parent entity state
     *
     * @throws RuntimeException
     */
    protected function validateParent(): void
    {
        if ($this->parent->getId() === null) {
            throw new RuntimeException(
                sprintf('Cannot query BelongsToMany relationship %s - parent entity %s is unsaved',
                    $this->relationName,
                    get_class($this->parent)
                )
            );
        }
    }

    /**
     * Prepare the query builder by resetting clauses
     */
    protected function prepareQueryBuilder(): void
    {
        $this->queryBuilder->resetDQLParts(['select', 'from', 'join', 'where']);
    }

    /**
     * Build the base query for the relationship
     */
    protected function buildBaseQuery(): void
    {
        $inverseProperty = $this->mapping['inversedBy'] ?? $this->mapping['mappedBy'];
        
        $this->queryBuilder
            ->select($this->relatedAlias)
            ->from($this->related, $this->relatedAlias)
            ->innerJoin(
                $this->relatedAlias . '.' . $inverseProperty,
                'parent_rel'
            )
            ->where('parent_rel.id = :parent_id')
            ->setParameter('parent_id', $this->parent->getId());
    }
}