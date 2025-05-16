<?php

namespace Axiom\Database\Relations;

use Doctrine\Common\Collections\ArrayCollection;

class BelongsTo extends Relation
{
    public function initiate()
    {
        // Get the foreign key column name from mapping
        $foreignKey = $this->mapping['joinColumns'][0]['name'];
        
        // Get the foreign key value from the parent entity
        $foreignValue = $this->parent->{'get'.ucfirst($foreignKey)}();
        
        // Build the query
        $this->queryBuilder
            ->select($this->relatedAlias)
            ->from($this->related, $this->relatedAlias)
            ->andWhere("{$this->relatedAlias}.id = :foreign_id")
            ->setParameter('foreign_id', $foreignValue);

        // Update builder context
        $this->builder->entityClass = $this->related;
        $this->builder->alias = $this->relatedAlias;
        
        return $this->builder;
    }
}