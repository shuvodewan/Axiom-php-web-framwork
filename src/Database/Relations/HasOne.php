<?php

namespace Axiom\Database\Relations;

use Doctrine\Common\Collections\ArrayCollection;

class HasOne extends Relation
{
    public function initiate()
    {
        $this->queryBuilder
            ->select($this->relatedAlias)
            ->from($this->related, $this->relatedAlias)
            ->setMaxResults(1);

        if (isset($this->mapping['mappedBy'])) {
            if (!$this->parent->getId()) {
                throw new \RuntimeException('Cannot query HasOne relationship for unsaved parent entity');
            }
            
            $this->queryBuilder
                ->andWhere("{$this->relatedAlias}.{$this->mapping['mappedBy']} = :parent_id")
                ->setParameter('parent_id', $this->parent->getId());
        } else {
            if (!isset($this->mapping['joinColumns'][0]['name'])) {
                throw new \RuntimeException('HasOne relationship requires either mappedBy or joinColumns configuration');
            }
            
            $foreignKey = $this->mapping['joinColumns'][0]['name'];
            $foreignValue = $this->parent->{'get' . ucfirst($foreignKey)}();
            
            if ($foreignValue === null) {
                throw new \RuntimeException('Foreign key value cannot be null for HasOne relationship');
            }
            
            $this->queryBuilder
                ->andWhere("{$this->relatedAlias}.id = :foreign_id")
                ->setParameter('foreign_id', $foreignValue);
        }
        
        $this->builder->setEntityClass($this->related);
        $this->builder->setAlias($this->relatedAlias);
        
        return $this->builder;
    }
}