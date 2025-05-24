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
 * providing CRUD operations, relationship management, and query building capabilities.
 * Implements active record pattern with Doctrine ORM integration.
 */
#[ORM\MappedSuperclass]
#[ORM\HasLifecycleCallbacks]
 class Entity
{

    use RelationShipMethodTrait;
    /**
     * The fully qualified class name of the concrete entity
     * 
     * @var string
     */
    protected static string $entityClass;

    /**
     * Faker to generate fake data
     * 
     */
    protected $faker;

    /**
     * Whether to automatically manage timestamp fields
     * 
     * @var bool
     */
    protected bool $timestamps = true;

    /**
     * Add list of properties to guarded to prevent users to modify by mistake
     * 
     * @var array
     */
    protected array $guarded = ['id','createdAt','updatedAt'];

    protected array $fillables = [];

    protected array $associats = [];

    protected bool $persist = true;


    #[ORM\PostLoad]
    public function initializeAfterHydration(): void
    {
        $this->addMappedCollections();
        $this->initializeDefaults();
    }
    
    /**
     * The creation timestamp of the entity
     * 
     * @var \DateTimeInterface|null
     */
    #[ORM\Column(type: "datetime", name:'created_at', nullable: true)]
    protected ?\DateTimeInterface $createdAt = null;
    
    /**
     * The last update timestamp of the entity
     * 
     * @var \DateTimeInterface|null
     */
    #[ORM\Column(type: "datetime", name:'updated_at' ,nullable: true)]
    protected ?\DateTimeInterface $updatedAt = null;

    /**
     * Entity constructor
     * 
     * Initializes the EntityManager and sets up collection properties
     */
    public function __construct()
    {
        $this->initializeDefaults();
    }
    

    protected function initializeDefaults(): void
    {
        $this->addMappedCollections();
        $this->fillables = array_diff($this->getFields(), $this->guarded);
        $this->associats = array_keys($this->getMeta()->associationMappings);
    }

    /**
     * Initialize all Collection properties with empty ArrayCollections
     * 
     * @return self
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
     * Handle static method calls
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
     * Handle dynamic method calls on instances
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

        // Handle getter methods
        if (str_starts_with($method, 'get')) {
            $property = lcfirst(substr($method, 3));
            return $this->$property ?? null;
        }

        // Handle setter methods
        if (str_starts_with($method, 'set')) {
            $property = lcfirst(substr($method, 3));

            if ($this->checkGuarded($property)) {
                throw new \RuntimeException("Cannot set guarded property: {$property}");
            }

            $this->$property = $args[0] ?? null;
            return $this;
        }

        throw new \BadMethodCallException("Method $method does not exist");
    }

    /**
     * Get the Doctrine repository instance
     * 
     * @return EntityRepository
     */
    protected static function getRepository(): EntityRepository
    {
        return  DB::getEntityManager()->getRepository(static::class);
    }

    /**
     * Create a new query builder instance
     * 
     * @return Builder
     */
    public static function query(): Builder
    {
        return new Builder( DB::getEntityManager(), static::class);
    }

     /**
     * Check property to gurded list before insert to database
     * 
     * @return boolean
     */
    public function checkGuarded($property): bool
    {
        return in_array($property, $this->guarded);
    }

    /**
     * Get a relationship query builder
     * 
     * @param string $relation The relationship name
     * @return Relation
     * @throws \RuntimeException If relationship doesn't exist
     */
    public function relation(string $relation): Relation
    {      
        $mapping = $this->getMeta()->getAssociationMapping($relation);
        $relatedClass = $mapping['targetEntity'];
        return $this->createRelation($relation, $relatedClass, $mapping);
    }

    /**
     * Create the appropriate relation instance
     */
    protected function createRelation(string $relation, string $relatedClass, $mapping)
    {
        $builder = new Builder( DB::getEntityManager(), $relatedClass, initiation:false);

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
     * @return static
     */
    public static function create(array $props)
    {
        $entity = new static();
        $entity->fill($props);

        if ($entity->timestamps) {
            $now = new \DateTime();
            $entity->createdAt = $now;
            $entity->updatedAt = $now;
        }
        
        if($entity->persist){
            DB::getEntityManager()->persist($entity);
            DB::getEntityManager()->flush();
        }

        return $entity;
    }

    /**
     * Update an existing entity
     *
     * @param array $props The properties to update
     * @return $this
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
     * Fill entity props (mass assignment)
     *
     * @param array $props The props to set
     * @return $this
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
     * Find the first entity matching the props or create it.
     *
     * @param array $props props to match
     * @param array $values Additional values to set if creating
     * @return static
     */
    public static function firstOrCreate(array $props, array $values = []): static
    {
        if (!is_null($instance = static::where($props)->first())) {
            return $instance;
        }

        return static::create(array_merge($props, $values));
    }

    /**
     * instantiate it (without persisting).
     *
     * @param array $props props to match
     * @return static
     */
    public static function new(array $props): static
    {
        $instance = new static();
        $instance->fill($props);
        return $instance;
    }

    /**
     * Find the first entity matching the props or instantiate it (without persisting).
     *
     * @param array $props props to match
     * @param array $values Additional values to set if instantiating
     * @return static
     */
    public static function firstOrNew(array $props, array $values = []): static
    {
        
        $query = self::query();
        $meta = DB::getEntityManager()->getClassMetadata(static::class);;

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
     * Update an existing entity or create it if it doesn't exist.
     *
     * @param array $props props to match
     * @param array $values Values to update/create with
     * @return static
     */
    public static function updateOrCreate(array $props, array $values = []): static
    {
        $query = self::query();
        $meta = DB::getEntityManager()->getClassMetadata(static::class);;

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
     * Save initiated instance.
     *
     * @return self
     */
    public function save(): self
    {
        DB::transaction(function() {
            DB::persist($this);
        });

        return $this;
    }

     /**
     * Save initiated instance.
     *
     * @return self
     */
    public function flash(): self
    {
        DB::transaction(function() {
            DB::flush($this);
        });

        return $this;
    }


    /**
     * Delete the entity from the database
     *
     * @return bool True if deletion was successful
     */
    public function delete(): bool
    {
        DB::transaction(function() {
            DB::remove($this);
        });
        return true;
    }
}