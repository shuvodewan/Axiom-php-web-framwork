<?php

namespace Axiom\Database\Relations;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\ClassMetadata;

class HasMany extends Relation
{
    public function initiate()
    {   
       if (!isset($this->mapping['mappedBy']) || empty($this->mapping['mappedBy'])) {
        throw new \RuntimeException('HasMany relationship requires a mappedBy property in the mapping');
        }

        $parentId = $this->parent->getId();
        if ($parentId === null) {
            throw new \RuntimeException('Cannot query HasMany relationship for unsaved parent entity');
        }

        $this->queryBuilder
            ->select($this->relatedAlias)
            ->from($this->related, $this->relatedAlias)
            ->where("{$this->relatedAlias}.{$this->mapping['mappedBy']} = :parent_id")
            ->setParameter('parent_id', $parentId);

        $this->builder->setEntityClass($this->related);
        $this->builder->setAlias($this->relatedAlias);
        
        return $this->builder;
    }
}