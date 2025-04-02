<?php

namespace Axiom\Database;

use App\Database\Builder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

class Entity
{
    protected static EntityManager $entityManager;
    protected static string $entityClass;

     /**
     * Whether to automatically manage timestamps
     * @var bool
     */
    protected bool $timestamps = true;
    
    #[ORM\Column(type: "datetime", nullable: true)]
    protected ?\DateTimeInterface $createdAt = null;
    
    #[ORM\Column(type: "datetime", nullable: true)]
    protected ?\DateTimeInterface $updatedAt = null;



    public function __construct()
    {
        self::initialize();
    }
    

    /**
     * Initialize the Entity system with Doctrine EntityManager
     */
    public static function initialize(): void
    {
        static::$entityManager = DatabaseManager::getInstance()->getEntityManager();
    }

    /**
     * Handle static method calls
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
     */
    public function __call(string $method, array $args)
    {
        // Getters
        if (str_starts_with($method, 'get')) {
            $property = lcfirst(substr($method, 3));
            return $this->$property ?? null;
        }

        // Setters
        if (str_starts_with($method, 'set')) {
            $property = lcfirst(substr($method, 3));
            $this->$property = $args[0] ?? null;
            return $this;
        }

        throw new \BadMethodCallException("Method $method does not exist");
    }

    /**
     * Get the Doctrine repository instance
     */
    protected static function getRepository(): EntityRepository
    {
        return static::$entityManager->getRepository(static::class);
    }

    /**
     * Create a new query builder instance
     */
    public static function query(): Builder
    {
        return new Builder(static::$entityManager, static::class);
    }

    /**
     * Create a new entity and persist it
     *
     * @param array $props
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
     * @param array $props
     * @return $this
     */
    public function update(array $props)
    {
        $this->fill($props);

        if ($this->timestamps) {
            $now = new \DateTime();
            $this->updatedAt = $now;
        }

        self::$entityManager->flush();
        return $this;
    }

    /**
     * Fill entity attributes (mass assignment)
     *
     * @param array $attributes
     * @return $this
     */
    public function fill(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            if (property_exists($this, $key)) {
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