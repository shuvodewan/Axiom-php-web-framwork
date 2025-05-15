<?php

namespace Axiom\Database;

use Axiom\Database\Builder;
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
class Entity
{
    /**
     * The Doctrine EntityManager instance
     * 
     * @var EntityManager
     */
    protected static EntityManager $entityManager;

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
        self::initialize();
        $this->addMappedCollections();
        $this->faker =  Factory::create();
    }
    
    /**
     * Initialize the Entity system with Doctrine EntityManager
     * 
     * @return void
     * @throws \RuntimeException If EntityManager cannot be initialized
     */
    public static function initialize(): void
    {
        static::$entityManager = DatabaseManager::getInstance()->getEntityManager();
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
        return self::$entityManager->getClassMetadata(static::class);
    }

    /**
     * Get all association names for this entity
     * 
     * @return array List of association/relationship names from Doctrine mappings
     */
    public function associats(): array
    {
        return array_keys($this->getMeta()->associationMappings);
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
     * Get all fillable fields (associations + fields excluding guarded)
     * 
     * @return array Combined list of fields safe for mass assignment
     */
    public function getFillables(): array
    {
        return array_merge($this->associats(), array_values(array_diff($this->getFields(), $this->guarded)));
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
        self::initialize();

        $repository = static::getRepository();
        if (method_exists($repository, $method)) {
            return $repository->$method(...$arguments);
        }
        
        $builder = new Builder(static::$entityManager, static::class);

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
        return static::$entityManager->getRepository(static::class);
    }

    /**
     * Create a new query builder instance
     * 
     * @return Builder
     */
    public static function query(): Builder
    {
        return new Builder(static::$entityManager, static::class);
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
        
        self::$entityManager->persist($entity);
        self::$entityManager->flush();
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

        self::$entityManager->flush();
        return $this;
    }

    /**
     * Fill entity attributes (mass assignment)
     *
     * @param array $attributes The attributes to set
     * @return $this
     */
    public function fill(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            if (property_exists($this, $key) && !$this->checkGuarded($key)) {
                $setter = 'set' . ucfirst($key);
                $this->$setter($value);
            }
        }
        return $this;
    }

    /**
     * Delete the entity from the database
     *
     * @return bool True if deletion was successful
     */
    public function delete(): bool
    {
        self::$entityManager->remove($this);
        self::$entityManager->flush();
        return true;
    }
}