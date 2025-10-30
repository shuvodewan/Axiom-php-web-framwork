<?php

namespace Axiom\Database\Relations;

use Axiom\Facade\DB;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\ClassMetadata;
use RuntimeException;

/**
 * Provides automatic generation of relationship management methods (addXxx/removeXxx/syncXxx)
 * with full persistence checking for both host and related entities.
 * 
 * This trait handles all relationship operations for Doctrine entities including:
 * - OneToOne
 * - OneToMany
 * - ManyToOne 
 * - ManyToMany
 * 
 * It ensures proper bi-directional relationship management and persistence state validation.
 */
trait RelationShipMethodTrait
{
    /**
     * Checks if the entity is persisted in the database
     * 
     * @return bool True if the entity has an ID and is managed by EntityManager
     */
    protected function isPersisted(): bool
    {
        return $this->getId() !== null && DB::getEntityManager()->contains($this);
    }

    /**
     * Ensures the entity is persisted before relationship operations
     * 
     * @param mixed $related Optional related entity to check instead of host
     * @throws RuntimeException When entity is not persisted
     */
    protected function ensurePersisted($related = null): void
    {
        $entity = $related ?? $this;
        if (!$entity->isPersisted()) {
            throw new RuntimeException(
                sprintf('Cannot modify relationships on unsaved %s entity', get_class($entity))
            );
        }
    }

    /**
     * Handles relationship actions (add/remove/sync)
     * 
     * @param string $action The action to perform (add/remove/sync)
     * @param string $property The relationship property name
     * @param mixed $relatedEntity The related entity/entities
     * @return self
     * @throws BadMethodCallException If property is not a relationship
     */
    protected function handleRelationshipAction(string $action, string $property, $relatedEntity): self
    {
        $meta = $this->getMeta();
        
        if (!$meta->hasAssociation($property)) {
            throw new \BadMethodCallException("Property {$property} is not a relationship");
        }

        $mapping = $meta->getAssociationMapping($property);
        
        $this->verifyPersistenceRequirements($mapping, $action, $relatedEntity);

        if ($action === 'add' || $action === 'sync') {
            $this->addToRelationship($property, $relatedEntity, $mapping, $action == 'sync');
        } else {
            $this->removeFromRelationship($property, $relatedEntity, $mapping);
        }

        $this->save();

        return $this;
    }

    /**
     * Verifies persistence requirements for the relationship operation
     * 
     * @param array $mapping The Doctrine association mapping
     * @param string $action The action being performed
     * @param mixed $relatedEntity The related entity/entities
     * @throws RuntimeException For invalid persistence states
     */
    protected function verifyPersistenceRequirements($mapping, string $action, $relatedEntity): void
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
    
        if ($mapping['type'] === ClassMetadata::MANY_TO_MANY) {
            if (!$relatedEntity->isPersisted()) {
                throw new RuntimeException(
                    sprintf('Cannot add unsaved %s entity to ManyToMany relationship', 
                    get_class($relatedEntity))
                );
            }
        }
    }

    /**
     * Checks if this is the owning side of the relationship
     * 
     * @param array $mapping The association mapping
     * @return bool True if this is the owning side
     */
    protected function isOwningSide($mapping): bool
    {
        return $mapping['isOwningSide'] ?? false;
    }

    /**
     * Adds or syncs entities to a relationship
     * 
     * @param string $property The relationship property
     * @param mixed $relatedEntity The entity/entities to add
     * @param array $mapping The association mapping
     * @param bool $sync Whether to sync (replace) existing relationships
     */
    protected function addToRelationship(string $property, $relatedEntity, $mapping, bool $sync = false): void
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
                $sync ?
                    $this->syncManyToMany($property, $relatedEntity, $mapping) :
                    $this->addToManyToMany($property, $relatedEntity, $mapping);
                break;
            case ClassMetadata::ONE_TO_ONE:
                $this->addToOneToOne($property, $relatedEntity, $mapping);
                break;
        }
    }

    /**
     * Adds entity to a OneToMany relationship
     * 
     * @param string $property The collection property
     * @param object $relatedEntity The entity to add
     * @param array $mapping The association mapping
     */
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

    /**
     * Adds entity to a ManyToOne relationship
     * 
     * @param string $property The reference property
     * @param object $relatedEntity The entity to set
     * @param array $mapping The association mapping
     */
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

    /**
     * Adds entity to a ManyToMany relationship
     * 
     * @param string $property The collection property
     * @param object $relatedEntity The entity to add
     * @param array $mapping The association mapping
     */
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

    /**
     * Adds entity to a OneToOne relationship
     * 
     * @param string $property The reference property
     * @param object $relatedEntity The entity to set
     * @param array $mapping The association mapping
     */
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

    /**
     * Removes entity from a relationship
     * 
     * @param string $property The relationship property
     * @param mixed $relatedEntity The entity to remove
     * @param array $mapping The association mapping
     */
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

    /**
     * Removes entity from a OneToMany relationship
     * 
     * @param string $property The collection property
     * @param object $relatedEntity The entity to remove
     * @param array $mapping The association mapping
     */
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

    /**
     * Removes entity from a ManyToOne relationship
     * 
     * @param string $property The reference property
     * @param array $mapping The association mapping
     */
    protected function removeFromManyToOne(string $property, array $mapping): void
    {
        $oldValue = $this->$property;
        $this->$property = null;
        
        if ($oldValue && isset($mapping['inversedBy'])) {
            $oldValue->{$mapping['inversedBy']}->removeElement($this);
        }
    }

    /**
     * Removes entity from a ManyToMany relationship
     * 
     * @param string $property The collection property
     * @param object $relatedEntity The entity to remove
     * @param array $mapping The association mapping
     */
    protected function removeFromManyToMany(string $property, $relatedEntity, array $mapping): void
    {
        $collection = $this->$property;
        
        if ($collection->removeElement($relatedEntity)) {
            $inverseProperty = $mapping['inversedBy'] ?? $mapping['mappedBy'];
            $relatedEntity->$inverseProperty->removeElement($this);
        }
    }

    /**
     * Removes entity from a OneToOne relationship
     * 
     * @param string $property The reference property
     * @param array $mapping The association mapping
     */
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

    /**
     * Syncs ManyToMany relationship with new set of entities
     * 
     * @param string $property The collection property
     * @param array $relatedEntities The new set of entities
     * @param array $mapping The association mapping
     */
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

    /**
     * Validates that an entity is of the expected type
     * 
     * @param mixed $entity The entity or array of entities to validate
     * @param string $expectedClass The expected class/interface name
     * @throws InvalidArgumentException For invalid entity types
     */
    protected function validateEntityType($entity, string $expectedClass): void
    {
        if (is_array($entity)) {
            foreach ($entity as $item) {
                if (!$item instanceof $expectedClass) {
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
            ));
        }
    }
}