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


    ////


    // In your Entity class

/**
 * Attach entities to a many-to-many relationship
 * 
 * @param mixed $ids Single ID or array of IDs
 * @param string $relation The relationship name
 * @param bool $touch Whether to update timestamps
 */
public function attach($ids, string $relation, bool $touch = true): void
{
    $this->performAttachDetach($ids, $relation, true, $touch);
}

/**
 * Detach entities from a many-to-many relationship
 * 
 * @param mixed $ids Single ID or array of IDs
 * @param string $relation The relationship name
 * @param bool $touch Whether to update timestamps
 */
public function detach($ids = null, string $relation, bool $touch = true): void
{
    if (is_null($ids)) {
        $this->performDetachAll($relation, $touch);
        return;
    }
    
    $this->performAttachDetach($ids, $relation, false, $touch);
}

/**
 * Sync entities in a many-to-many relationship
 * 
 * @param array $ids Array of IDs
 * @param string $relation The relationship name
 * @param bool $touch Whether to update timestamps
 */
public function sync(array $ids, string $relation, bool $touch = true): void
{
    $this->performSync($ids, $relation, $touch);
}

// Helper methods
protected function performAttachDetach($ids, string $relation, bool $attach, bool $touch): void
{
    $ids = is_array($ids) ? $ids : [$ids];
    $metadata = DB::getEntityManager()->getClassMetadata(static::class);
    $mapping = $metadata->getAssociationMapping($relation);
    
    foreach ($ids as $id) {
        $relatedEntity = DB::getEntityManager()->getReference($mapping['targetEntity'], $id);
        
        if ($attach) {
            $this->$relation->add($relatedEntity);
            // Handle inverse side if bidirectional
            if ($mapping['isOwningSide'] && isset($mapping['inversedBy'])) {
                $inverseRelation = $mapping['inversedBy'];
                $relatedEntity->$inverseRelation->add($this);
            }
        } else {
            $this->$relation->removeElement($relatedEntity);
            // Handle inverse side if bidirectional
            if ($mapping['isOwningSide'] && isset($mapping['inversedBy'])) {
                $inverseRelation = $mapping['inversedBy'];
                $relatedEntity->$inverseRelation->removeElement($this);
            }
        }
    }
    
    if ($touch && $this->timestamps) {
        $this->updatedAt = new \DateTime();
    }
    
    DB::getEntityManager()->flush();
}

protected function performDetachAll(string $relation, bool $touch): void
{
    $metadata = DB::getEntityManager()->getClassMetadata(static::class);
    $mapping = $metadata->getAssociationMapping($relation);
    
    foreach ($this->$relation as $relatedEntity) {
        $this->$relation->removeElement($relatedEntity);
        // Handle inverse side if bidirectional
        if ($mapping['isOwningSide'] && isset($mapping['inversedBy'])) {
            $inverseRelation = $mapping['inversedBy'];
            $relatedEntity->$inverseRelation->removeElement($this);
        }
    }
    
    if ($touch && $this->timestamps) {
        $this->updatedAt = new \DateTime();
    }
    
    DB::getEntityManager()->flush();
}

protected function performSync(array $ids, string $relation, bool $touch): void
{
    $currentIds = [];
    $metadata = DB::getEntityManager()->getClassMetadata(static::class);
    $mapping = $metadata->getAssociationMapping($relation);
    
    // Get current IDs
    foreach ($this->$relation as $relatedEntity) {
        $currentIds[] = $relatedEntity->getId();
    }
    
    $idsToAttach = array_diff($ids, $currentIds);
    $idsToDetach = array_diff($currentIds, $ids);
    
    if (!empty($idsToAttach)) {
        $this->performAttachDetach($idsToAttach, $relation, true, false);
    }
    
    if (!empty($idsToDetach)) {
        $this->performAttachDetach($idsToDetach, $relation, false, false);
    }
    
    if ($touch && $this->timestamps) {
        $this->updatedAt = new \DateTime();
        DB::getEntityManager()->flush();
    }
}
}