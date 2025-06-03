<?php

namespace Axiom\Database;

use Axiom\Database\Builder;
use Axiom\Database\Relations\BelongsTo;
use Axiom\Database\Relations\BelongsToMany;
use Axiom\Database\Relations\HasMany;
use Axiom\Database\Relations\HasOne;
use Axiom\Database\Relations\Relation;
use Axiom\Database\Relations\RelationShipMethodTrait;
use Axiom\Facade\DB;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ClassMetadata;
use Faker\Factory;

/**
 * Base Entity class providing common database operations
 * 
 * This abstract class serves as the foundation for all Doctrine entities in the system,
 * implementing an active record pattern with Doctrine ORM integration. It provides:
 * 
 * - CRUD operations (create, read, update, delete)
 * - Relationship management (hasOne, hasMany, belongsTo, belongsToMany)
 * - Query building capabilities
 * - Mass assignment protection
 * - Timestamp management
 * - Dynamic method handling for getters/setters
 * - Relationship operations (add/remove/sync)
 * 
 * The class uses Doctrine ORM for persistence and provides a fluent interface
 * for common operations. It supports both static and instance method calls
 * for query building and relationship management.
 */
#[ORM\MappedSuperclass]
#[ORM\HasLifecycleCallbacks]
class Entity
{
    use RelationShipMethodTrait;

    /**
     * The fully qualified class name of the concrete entity
     * @var string
     */
    protected static string $entityClass;

    /**
     * Whether to automatically manage timestamp fields
     * @var bool
     */
    protected bool $timestamps = true;

    /**
     * Properties that cannot be mass-assigned
     * @var array
     */
    protected array $guarded = ['id','createdAt','updatedAt'];

     /**
     * Properties that cannot be publicly assigned
     * @var array
     */
    protected array $ignore = ['timestamps','ignore','guarded','persist','associats','persist','fillables'];

    /**
     * Properties that can be mass-assigned
     * @var array
     */
    protected array $fillables = [];

    /**
     * Relationship properties of the entity
     * @var array
     */
    protected array $associats = [];

    /**
     * Whether to automatically persist changes
     * @var bool
     */
    protected bool $persist = true;

    /**
     * The creation timestamp of the entity
     * @var \DateTimeInterface|null
     */
    #[ORM\Column(type: "datetime", name:'created_at', nullable: true)]
    protected ?\DateTimeInterface $createdAt = null;
    
    /**
     * The last update timestamp of the entity
     * @var \DateTimeInterface|null
     */
    #[ORM\Column(type: "datetime", name:'updated_at' ,nullable: true)]
    protected ?\DateTimeInterface $updatedAt = null;

    /**
     * Initialize the entity with default values and collections
     */
    public function __construct()
    {
        $this->initializeDefaults();
    }

    /**
     * Set up default values for the entity
     * 
     * Initializes collections, fillable fields, and association mappings
     */
    protected function initializeDefaults(): void
    {
        $this->addMappedCollections();
        $this->fillables = array_diff($this->getFields(), $this->guarded);
        $this->associats = array_keys($this->getMeta()->associationMappings);
    }

    /**
     * Initialize all Collection properties with empty ArrayCollections
     * 
     * @return self Returns the entity instance for method chaining
     */
    public function addMappedCollections(): self
    {
        $reflectionClass = new \ReflectionClass(static::class);

        foreach ($reflectionClass->getProperties() as $property) {
            if ($property->getType()?->getName() === Collection::class) {
                $name = $property->getName();
                $this->$name = new ArrayCollection();
            }
        }

        return $this;
    }

    /**
     * Get the Doctrine metadata for the current entity class
     * 
     * @return ClassMetadata The Doctrine metadata containing all mapping information
     */
    public function getMeta(): ClassMetadata
    {
        return DB::getEntityManager()->getClassMetadata(static::class);
    }

    /**
     * Get all field names for this entity (excluding associations)
     * 
     * @return array List of field/property names from Doctrine mappings
     */
    public function getFields(): array
    {
        return array_keys($this->getMeta()->fieldMappings);
    }

    /**
     * Handle dynamic static method calls
     * 
     * Routes calls to either the repository or query builder
     * 
     * @param string $method The method name being called
     * @param array $arguments The method arguments
     * @return mixed
     * @throws \BadMethodCallException If method doesn't exist
     */
    public static function __callStatic(string $method, array $arguments)
    {
        $repository = static::getRepository();
        if (method_exists($repository, $method)) {
            return $repository->$method(...$arguments);
        }
        
        $builder = self::query();
        if (method_exists($builder, $method)) {
            return $builder->$method(...$arguments);
        }

        throw new \BadMethodCallException(sprintf(
            'Undefined method %s::%s()',
            static::class,
            $method
        ));
    }

    /**
     * Handle dynamic instance method calls
     * 
     * Processes relationship actions, getters/setters, and property access
     * 
     * @param string $method The method name being called
     * @param array $args The method arguments
     * @return mixed
     * @throws \BadMethodCallException If method doesn't exist
     */
    public function __call(string $method, array $args)
    {
        if (preg_match('/^(add|remove|sync)([A-Z][a-zA-Z0-9]*)$/', $method, $matches)) {
            $action = $matches[1];
            $property = lcfirst($matches[2]);
            return $this->handleRelationshipAction($action, $property, $args[0] ?? null);
        }

        if (in_array($method, $this->associats)) {
            return $this->relation($method);
        }

        if (str_starts_with($method, 'get')) {
            $property = lcfirst(substr($method, 3));
            return $this->$property ?? null;
        }

        if (str_starts_with($method, 'set')) {
            $property = lcfirst(substr($method, 3));
            if ($this->checkGuarded($property)) {
                throw new \RuntimeException("Cannot set guarded property: {$property}");
            }

            if ($this->checkIgnore($property)) {
                throw new \RuntimeException("Cannot set protected property: {$property}");
            }
            $this->$property = $args[0] ?? null;
            return $this;
        }

        throw new \BadMethodCallException("Method $method does not exist");
    }

    /**
     * Get the Doctrine repository instance for this entity
     * 
     * @return EntityRepository The repository instance
     */
    protected static function getRepository(): EntityRepository
    {
        return DB::getEntityManager()->getRepository(static::class);
    }

    /**
     * Create a new query builder instance for this entity
     * 
     * @return Builder A query builder instance
     */
    public static function query(): Builder
    {
        return new Builder(DB::getEntityManager(), static::class);
    }

    /**
     * Check if a property is guarded against mass assignment
     * 
     * @param string $property The property name to check
     * @return bool True if the property is guarded
     */
    public function checkGuarded($property): bool
    {
        return in_array($property, $this->guarded);
    }

     /**
     * Check if a property is guarded against mass assignment
     * 
     * @param string $property The property name to check
     * @return bool True if the property is guarded
     */
    public function checkIgnore($property): bool
    {
        return in_array($property, $this->ignore);
    }

    /**
     * Get a relationship query builder for a relation
     * 
     * @param string $relation The relationship name
     * @return Relation The relationship instance
     * @throws \RuntimeException If relationship doesn't exist
     */
    public function relation(string $relation): Relation
    {      
        $mapping = $this->getMeta()->getAssociationMapping($relation);
        $relatedClass = $mapping['targetEntity'];
        return $this->createRelation($relation, $relatedClass, $mapping);
    }

    /**
     * Create the appropriate relation instance based on mapping type
     * 
     * @param string $relation The relationship name
     * @param string $relatedClass The target entity class
     * @param array $mapping The association mapping
     * @return Relation The created relationship instance
     * @throws \RuntimeException For unsupported relationship types
     */
    protected function createRelation(string $relation, string $relatedClass, $mapping): Relation
    {
        $builder = new Builder(DB::getEntityManager(), $relatedClass, initiation:false);

        switch ($mapping['type']) {
            case ClassMetadata::ONE_TO_ONE:
                return new HasOne($builder, $this, $relatedClass, $relation);
            case ClassMetadata::ONE_TO_MANY:
                return new HasMany($builder, $this, $relatedClass, $relation);
            case ClassMetadata::MANY_TO_ONE:
                return new BelongsTo($builder, $this, $relatedClass, $relation);
            case ClassMetadata::MANY_TO_MANY:
                return new BelongsToMany($builder, $this, $relatedClass, $relation);
            default:
                throw new \RuntimeException("Unsupported relationship type");
        }
    }

    /**
     * Create a new entity and persist it
     * 
     * @param array $props The properties to set on the new entity
     * @return static The created entity instance
     */
    public static function create(array $props)
    {
        $entity = new static();
        $entity->fill($props);

        if ($entity->timestamps) {
            $now = new \DateTime();
            $entity->createdAt = isset($props['createdAt']) && $props['createdAt']?$props['createdAt']:$now;
            $entity->updatedAt = isset($props['updatedAt']) && $props['updatedAt']?$props['updatedAt']:$now;
        }
        
        if($entity->persist){
            DB::getEntityManager()->persist($entity);
            DB::getEntityManager()->flush();
        }

        return $entity;
    }

    /**
     * Update an existing entity with new properties
     * 
     * @param array $props The properties to update
     * @return $this The updated entity instance
     */
    public function update(array $props)
    {
        $this->fill($props);
        if ($this->timestamps) {
            $this->updatedAt = new \DateTime();
        }

        if($this->persist){
            DB::getEntityManager()->flush();
        }

        return $this;
    }

    /**
     * Fill entity properties (mass assignment)
     * 
     * Only fills non-guarded properties and handles relationships
     * 
     * @param array $props The properties to set
     * @return $this The entity instance
     */
    public function fill(array $props)
    {
        foreach ($props as $key => $value) {
            if (property_exists($this, $key) && !$this->checkGuarded($key)) {
                if(in_array($key,$this->associats)){
                    $this->handleRelationshipAction('add',$key,$value);
                }else{
                    $setter = 'set' . ucfirst($key);
                    $this->$setter($value);
                }
            }
        }
        return $this;
    }

    /**
     * Find the first entity matching criteria or create new one
     * 
     * @param array $props Criteria to match
     * @param array $values Additional values for creation
     * @return static The found or created entity
     */
    public static function firstOrCreate(array $props, array $values = []): static
    {
        $query = self::query();
        $meta = DB::getEntityManager()->getClassMetadata(static::class);

        foreach ($props as $key => $value) {
            if ($meta->hasAssociation($key)) {
                $mapping = $meta->getAssociationMapping($key);
                
                if ($mapping['isOwningSide'] && $mapping['type'] !== ClassMetadata::MANY_TO_MANY) {
                    $query->where($key, $value);
                }
            } else {
                $query->where($key, $value);
            }
        }

        if ($instance = $query->first()) {
            return $instance;
        }

        return static::create(array_merge($props, $values));
    }

    /**
     * Create a new entity instance without persisting
     * 
     * @param array $props The properties to set
     * @return static The new entity instance
     */
    public static function new(array $props): static
    {
        $instance = new static();
        $instance->fill($props);
        return $instance;
    }

    /**
     * Update existing entity or create new one if not found
     * 
     * @param array $props Criteria to match
     * @param array $values Values to update/create with
     * @return static The updated or created entity
     */
    public static function updateOrCreate(array $props, array $values = []): static
    {
        $query = self::query();
        $meta = DB::getEntityManager()->getClassMetadata(static::class);

        foreach ($props as $key => $value) {
            if ($meta->hasAssociation($key)) {
                $mapping = $meta->getAssociationMapping($key);
                
                if ($mapping['isOwningSide'] && $mapping['type'] !== ClassMetadata::MANY_TO_MANY) {
                    $query->where($key, $value);
                }
            } else {
                $query->where($key, $value);
            }
        }

        if ($instance = $query->first()) {
            $instance->update($values);
            return $instance;
        }

        return static::create(array_merge($props, $values));
    }

    /**
     * Persist the entity to database
     * 
     * @return self The entity instance
     */
    public function save(): self
    {
        if ($this->timestamps) {
            $now = new \DateTime();
            if(!$this->isPersisted()){
                $this->createdAt = $this->createdAt?$this->createdAt:$now;
            }
            $this->updatedAt = $this->updatedAt?$this->updatedAt:$now;;
        }

        DB::persist($this);
        return $this;
    }

    /**
     * Flush the entity changes to database
     * 
     * @return self The entity instance
     */
    public function flash(): self
    {
        DB::flush($this);
        return $this;
    }

    /**
     * Delete the entity from database
     * 
     * @return bool True if deletion was successful
     */
    public function delete(): bool
    {
        DB::remove($this);
        return true;
    }
}