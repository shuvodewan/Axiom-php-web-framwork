<?php

namespace Axiom\Database\Relations;

use Axiom\Facade\DB;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\ClassMetadata;
use RuntimeException;

/**
 * Provides automatic generation of relationship management methods (addXxx/removeXxx)
 * with full persistence checking for both host and related entities.
 */
trait RelationShipMethodTrait
{

    /**
     * Checks if the entity is persisted in the database.
     */
    protected function isPersisted(): bool
    {
        return $this->getId() !== null && DB::getEntityManager()->contains($this);
    }

    /**
     * Ensures the entity is persisted before relationship operations.
     * 
     * @throws RuntimeException When entity is not persisted
     */
    protected function ensurePersisted($related=null): void
    {
        $entity = $related??$this;
        if (!$entity->isPersisted()) {
            throw new RuntimeException(
                sprintf('Cannot modify relationships on unsaved %s entity', get_class($entity))
            );
        }
    }

    protected function handleRelationshipAction(string $action, string $property, $relatedEntity): self
    {
        $meta = $this->getMeta();
        
        if (!$meta->hasAssociation($property)) {
            throw new \BadMethodCallException("Property {$property} is not a relationship");
        }

        $mapping = $meta->getAssociationMapping($property);
        
        // Verify persistence requirements based on relationship type
        $this->verifyPersistenceRequirements($mapping, $action, $relatedEntity);

        if ($action === 'add' || $action === 'sync') {
            $this->addToRelationship($property, $relatedEntity, $mapping, $action=='sync');
        } else {
            $this->removeFromRelationship($property, $relatedEntity, $mapping);
        }

        $this->save();

        return $this;
    }

    /**
     * Verifies persistence requirements for the relationship operation.
     */
    protected function verifyPersistenceRequirements( $mapping, string $action, $relatedEntity): void
    {
        
    
        if ($action === 'sync') {
            if (!is_array($relatedEntity)) {
                throw new RuntimeException(
                    'Related entities should be provided as an array for sync operation'
                );
            }
            
            foreach ($relatedEntity as $entity) {
                if (!$entity->isPersisted()) {
                    throw new RuntimeException(
                        sprintf('Cannot sync unsaved %s entity to ManyToMany relationship', 
                        get_class($entity))
                    );
                }
            }
            return;
        }

        if (!$this->isOwningSide($mapping)) {
            $this->ensurePersisted();
        } else {
            $this->ensurePersisted($relatedEntity);
        }
    
        // For ManyToMany, both entities must be persisted
        if ($mapping['type'] === ClassMetadata::MANY_TO_MANY) {
            if (!$relatedEntity->isPersisted()) {
                throw new RuntimeException(
                    sprintf('Cannot add unsaved %s entity to ManyToMany relationship', 
                    get_class($relatedEntity))
                );
            }
        }
    }

    protected function isOwningSide($mapping): bool
    {
        return $mapping['isOwningSide'] ?? false;
    }

    protected function addToRelationship(string $property, $relatedEntity, $mapping, $sync=false): void
    {
        $this->validateEntityType($relatedEntity, $mapping['targetEntity']);

        switch ($mapping['type']) {
            case ClassMetadata::ONE_TO_MANY:
                $this->addToOneToMany($property, $relatedEntity, $mapping);
                break;
            case ClassMetadata::MANY_TO_ONE:
                $this->addToManyToOne($property, $relatedEntity, $mapping);
                break;
            case ClassMetadata::MANY_TO_MANY:
                $sync?
                $this->syncManyToMany($property, $relatedEntity, $mapping)
                :$this->addToManyToMany($property, $relatedEntity, $mapping);
                break;
            case ClassMetadata::ONE_TO_ONE:
                $this->addToOneToOne($property, $relatedEntity, $mapping);
                break;
        }
    }

    protected function addToOneToMany(string $property, $relatedEntity, $mapping): void
    {
        $collection = $this->$property;

        if (!$collection->contains($relatedEntity)) {
            $collection->add($relatedEntity);
            
            if (isset($mapping['mappedBy'])) {
                $setter = 'set' . ucfirst($mapping['mappedBy']);
                $relatedEntity->$setter($this);
            }
        }
    }

    protected function addToManyToOne(string $property, $relatedEntity, $mapping): void
    {   
        if (isset($mapping['inversedBy'])) {
            $setter = 'set' . ucfirst($property);
            $this->$setter($relatedEntity);

            $inverseCollection = $relatedEntity->{$mapping['inversedBy']};
            if (!$inverseCollection->contains($this)) {
                $inverseCollection->add($this);
            }  
        }
        
    }

    protected function addToManyToMany(string $property, $relatedEntity, $mapping): void
    {
        $collection = $this->$property;
        if (!$collection->contains($relatedEntity)) {
            $collection->add($relatedEntity);
            $inverseProperty = $mapping['inversedBy'] ?? $mapping['mappedBy'];
            $inverseCollection = $relatedEntity->$inverseProperty;
            
            if (!$inverseCollection->contains($this)) {
                $inverseCollection->add($this);
            }
        }
    }

    protected function addToOneToOne(string $property, $relatedEntity, array $mapping): void
    {
        $oldValue = $this->$property;
        $this->$property = $relatedEntity;
        
        if ($mapping['isOwningSide']) {
            if (isset($mapping['inversedBy'])) {
                $relatedEntity->{$mapping['inversedBy']} = $this;
                if (!$relatedEntity->isPersisted()) {
                    DB::getEntityManager()->persist($relatedEntity);
                }
            }
            
            if ($oldValue && isset($mapping['inversedBy'])) {
                $oldValue->{$mapping['inversedBy']} = null;
            }
        } else {
            if (isset($mapping['mappedBy'])) {
                $relatedEntity->{$mapping['mappedBy']} = $this;
            }
            
            if ($oldValue && isset($mapping['mappedBy'])) {
                $oldValue->{$mapping['mappedBy']} = null;
            }
        }
    }

    protected function removeFromRelationship(string $property, $relatedEntity, array $mapping): void
    {
        $this->validateEntityType($relatedEntity, $mapping['targetEntity']);

        switch ($mapping['type']) {
            case ClassMetadata::ONE_TO_MANY:
                $this->removeFromOneToMany($property, $relatedEntity, $mapping);
                break;
            case ClassMetadata::MANY_TO_ONE:
                $this->removeFromManyToOne($property, $mapping);
                break;
            case ClassMetadata::MANY_TO_MANY:
                $this->removeFromManyToMany($property, $relatedEntity, $mapping);
                break;
            case ClassMetadata::ONE_TO_ONE:
                $this->removeFromOneToOne($property, $mapping);
                break;
        }
    }

    protected function removeFromOneToMany(string $property, $relatedEntity, array $mapping): void
    {
        $collection = $this->$property;
        
        if ($collection->removeElement($relatedEntity)) {
            if (isset($mapping['mappedBy'])) {
                $getter = 'get' . ucfirst($mapping['mappedBy']);
                if ($relatedEntity->$getter() === $this) {
                    $setter = 'set' . ucfirst($mapping['mappedBy']);
                    $relatedEntity->$setter(null);
                }
            }
        }
    }

    protected function removeFromManyToOne(string $property, array $mapping): void
    {
        $oldValue = $this->$property;
        $this->$property = null;
        
        if ($oldValue && isset($mapping['inversedBy'])) {
            $oldValue->{$mapping['inversedBy']}->removeElement($this);
        }
    }

    protected function removeFromManyToMany(string $property, $relatedEntity, array $mapping): void
    {
        $collection = $this->$property;
        
        if ($collection->removeElement($relatedEntity)) {
            $inverseProperty = $mapping['inversedBy'] ?? $mapping['mappedBy'];
            $relatedEntity->$inverseProperty->removeElement($this);
        }
    }

    protected function removeFromOneToOne(string $property, array $mapping): void
    {
        $oldValue = $this->$property;
        $this->$property = null;
        
        if ($oldValue) {
            if ($mapping['isOwningSide'] && isset($mapping['inversedBy'])) {
                $oldValue->{$mapping['inversedBy']} = null;
            } elseif (isset($mapping['mappedBy'])) {
                $oldValue->{$mapping['mappedBy']} = null;
            }
        }
    }

    protected function syncManyToMany(string $property, array $relatedEntities, $mapping): void
    {
        $collection = $this->$property;
        $newEntities = new ArrayCollection($relatedEntities);
        
        foreach ($collection as $existingEntity) {
            if (!$newEntities->contains($existingEntity)) {
                $this->removeFromManyToMany($property, $existingEntity, $mapping);
            }
        }

        foreach ($newEntities as $newEntity) {
            if (!$collection->contains($newEntity)) {
                $this->addToManyToMany($property, $newEntity, $mapping);
            }
        }

    }


    protected function validateEntityType($entity, string $expectedClass): void
    {
        if(is_array($entity)){
            foreach($entity as $item){
                if(!$item instanceof $expectedClass){
                    throw new \InvalidArgumentException(sprintf(
                        'Expected entity of type %s, got %s',
                        $expectedClass,
                        is_object($item) ? get_class($item) : gettype($item)
                    ));
                } 
            }
            return;
        }

        if (!$entity instanceof $expectedClass) {
            throw new \InvalidArgumentException(sprintf(
                    'Expected entity of type %s, got %s',
                    $expectedClass,
                    is_object($entity) ? get_class($entity) : gettype($entity)
                )
            );
        }
    }

}