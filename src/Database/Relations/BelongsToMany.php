<?php

namespace Axiom\Database\Relations;

use Doctrine\Common\Collections\ArrayCollection;

class BelongsToMany extends Relation
{
    public function initiate()
    {
        // Clear existing query parts
        $this->queryBuilder->resetDQLParts(['select', 'from', 'join', 'where']);
        
        // Get the inverse relation name from mapping
        $inverseProperty = $this->mapping['inversedBy'] ?? $this->mapping['mappedBy'];
        
        // Build the query using proper entity associations
        $this->queryBuilder
            ->select($this->relatedAlias)
            ->from($this->related, $this->relatedAlias)
            ->innerJoin(
                $this->relatedAlias . '.' . $inverseProperty,
                'parent_rel'
            )
            ->where('parent_rel.id = :parent_id')
            ->setParameter('parent_id', $this->parent->getId());

        // Update builder context
        $this->builder->entityClass = $this->related;
        $this->builder->alias = $this->relatedAlias;
        
        return $this->builder;
    }
}