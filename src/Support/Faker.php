<?php

namespace Axiom\Support;

use Doctrine\ORM\Mapping\ClassMetadata;
use Faker\Factory;
use Faker\Generator;

class Faker
{
    /**
     * The Faker generator instance.
     *
     * @var \Faker\Generator
     */
    protected $generator;

    /**
     * Create a new Faker instance.
     *
     * @param string|null $locale The locale to use (e.g. 'en_US', 'fr_FR')
     * 
     * @example 
     * $faker = new Faker(); // Uses default locale
     * $faker = new Faker('fr_FR'); // French locale
     */
    public function __construct($locale = null)
    {
        $this->generator = $locale ? Factory::create($locale) : Factory::create();
    }

    /**
     * Get the Faker generator instance.
     *
     * @return \Faker\Generator
     * 
     * @example
     * $generator = $faker->generator();
     * $name = $generator->name;
     */
    public function generator()
    {
        return $this->generator;
    }

    /**
     * Handle dynamic method calls to the Faker generator.
     *
     * @param string $method The Faker formatter method to call
     * @param array $parameters Parameters to pass to the formatter
     * @return mixed
     * 
     * @example
     * $faker->name(); // Generates random name
     * $faker->email(); // Generates random email
     * $faker->text(200); // Generates 200 chars of random text
     */
    public function __call($method, $parameters)
    {
        return $this->generator->$method(...$parameters);
    }

    /**
     * Set a custom generator instance.
     *
     * @param \Faker\Generator $generator
     * @return $this
     * 
     * @example
     * $customGenerator = Factory::create();
     * $faker->setGenerator($customGenerator);
     */
    public function setGenerator(Generator $generator)
    {
        $this->generator = $generator;
        return $this;
    }

    /**
     * Change the locale of the generator.
     *
     * @param string $locale The new locale (e.g. 'de_DE', 'ja_JP')
     * @return $this
     * 
     * @example
     * $faker->locale('es_ES')->name(); // Spanish names
     */
    public function locale($locale)
    {
        $this->generator = Factory::create($locale);
        return $this;
    }

    /**
     * Add a custom provider to the generator.
     *
     * @param object $provider A provider instance
     * @return $this
     * 
     * @example
     * class CustomProvider {
     *     public function productName() {
     *         $products = ['Widget', 'Gadget', 'Thingy'];
     *         return $products[array_rand($products)];
     *     }
     * }
     * $faker->addProvider(new CustomProvider())->productName(); // 'Widget'
     */
    public function addProvider($provider)
    {
        $this->generator->addProvider($provider);
        return $this;
    }

    /**
     * Get the current locale.
     *
     * @return string
     * 
     * @example
     * $locale = $faker->getLocale(); // 'en_US'
     */
    public function getLocale()
    {
        return $this->generator->getLocale();
    }

    /**
     * Generate fake data for a specific formatter.
     *
     * @param string $formatter The formatter name
     * @param array $arguments Formatter arguments
     * @return mixed
     * 
     * @example
     * $faker->fake('name'); // Same as $faker->name()
     * $faker->fake('date', ['Y-m-d']); // '2023-05-15'
     */
    public function fake($formatter, $arguments = [])
    {
        return $this->generator->format($formatter, $arguments);
    }

    /**
     * Generate a random digit (0-9).
     *
     * @return int
     * 
     * @example
     * $digit = $faker->digit(); // 7
     */
    public function digit()
    {
        return $this->generator->randomDigit;
    }

    /**
     * Generate a random number between given bounds.
     *
     * @param int $min Minimum value (default: 0)
     * @param int $max Maximum value (default: 2147483647)
     * @return int
     * 
     * @example
     * $number = $faker->numberBetween(1, 100); // 42
     * $bigNumber = $faker->numberBetween(1000, 9999); // 5827
     */
    public function numberBetween($min = 0, $max = 2147483647)
    {
        return $this->generator->numberBetween($min, $max);
    }

    /**
     * Generate a random float number.
     *
     * @param int|null $nbMaxDecimals Maximum decimals (default: null)
     * @param float $min Minimum value (default: 0)
     * @param float|null $max Maximum value (default: null)
     * @return float
     * 
     * @example
     * $float = $faker->randomFloat(); // 0.7521
     * $price = $faker->randomFloat(2, 1, 100); // 45.67
     */
    public function randomFloat($nbMaxDecimals = null, $min = 0, $max = null)
    {
        return $this->generator->randomFloat($nbMaxDecimals, $min, $max);
    }

    /**
     * Generate a random letter (a-z).
     *
     * @return string
     * 
     * @example
     * $letter = $faker->letter(); // 'd'
     */
    public function letter()
    {
        return $this->generator->randomLetter;
    }

    /**
     * Generate a random string of specified length.
     *
     * @param int $length Desired string length (default: 16)
     * @return string
     * 
     * @example
     * $string = $faker->string(10); // 'aBcDeFgHiJ'
     * $token = $faker->string(32); // 'xK8pL2qR9sT5vW1yZ3uX7oN4iM6jB0'
     */
    public function string($length = 16)
    {
        return $this->generator->lexify(str_repeat('?', $length));
    }

    /**
     * Generate a random boolean value.
     *
     * @param int $chanceOfGettingTrue Chance of getting true (0-100, default: 50)
     * @return bool
     * 
     * @example
     * $bool = $faker->boolean(); // true or false (50/50)
     * $likelyTrue = $faker->boolean(80); // 80% chance of true
     */
    public function boolean($chanceOfGettingTrue = 50)
    {
        return $this->generator->boolean($chanceOfGettingTrue);
    }

    /**
     * Generate a random date between two dates.
     *
     * @param string|\DateTime $startDate Start date (default: '-30 years')
     * @param string|\DateTime $endDate End date (default: 'now')
     * @param string|null $format Output format (null returns DateTime)
     * @return string|\DateTime
     * 
     * @example
     * $date = $faker->dateBetween(); // '1995-03-14'
     * $dateTime = $faker->dateBetween('-1 week', 'now', null); // DateTime object
     * $futureDate = $faker->dateBetween('now', '+1 year', 'Y-m-d H:i:s');
     */
    public function dateBetween($startDate = '-30 years', $endDate = 'now', $format = 'Y-m-d')
    {
        $date = $this->generator->dateTimeBetween($startDate, $endDate);
        return $format ? $date->format($format) : $date;
    }

    /**
     * Generate a random element from an array.
     *
     * @param array $array The array to pick from
     * @return mixed
     * 
     * @example
     * $colors = ['red', 'green', 'blue'];
     * $color = $faker->randomElement($colors); // 'green'
     */
    public function randomElement(array $array)
    {
        return $this->generator->randomElement($array);
    }

    /**
     * Generate a random key from an array.
     *
     * @param array $array The array to pick from
     * @return mixed
     * 
     * @example
     * $data = ['a' => 1, 'b' => 2, 'c' => 3];
     * $key = $faker->randomKey($data); // 'b'
     */
    public function randomKey(array $array)
    {
        return $this->generator->randomKey($array);
    }

     /**
     * Generate and persist multiple entities with random data
     *
     * @param string $entityClass The entity class to generate
     * @param int $count Number of entities to generate
     * @param callable|null $callback Optional callback to modify each entity
     * @return array|Entity The generated entity/entities
     *
     * @example
     * // Generate 10 random roles
     * $roles = (new Faker())->entity(Role::class, 10);
     *
     * // Generate with custom callback
     * $users = (new Faker())->entity(User::class, 5, function($user) {
     *     $user->setActive(true);
     * });
     */
    public function entity(string $entityClass, int $count = 1, ?callable $callback = null)
    {
        $after = null;
        $entity = new $entityClass();
        $metadata = $entity->getMeta();
        $fillables = $this->getFillables();

        for ($i = 0; $i < $count; $i++) {
            $data = $this->generateEntityData($metadata, $fillables);
            $after = $callback(null,$data,'before');

            $entity = $entity->fill($data);

            if ($after && is_callable($after)) {
                $callback($entity,null,'after');
            }
        }

        if($count==1){
            return  $entity;
        }
    }

    /**
     * Generate random data for an entity based on its metadata
     *
     * @param ClassMetadata $metadata
     * @param array $fillables
     * @return array
     */
    protected function generateEntityData(ClassMetadata $metadata, array $fillables): array
    {
        $data = [];
        
        foreach ($fillables as $property) {
            if ($metadata->hasField($property)) {
                $fieldMapping = $metadata->getFieldMapping($property);
                $data[$property] = $this->generateFieldValue($fieldMapping);
            }
        }
        
        return $data;
    }

    /**
     * Generate random value for a field based on its type
     *
     * @param array $fieldMapping
     * @return mixed
     */
    protected function generateFieldValue($fieldMapping)
    {
        $type = $fieldMapping['type'] ?? 'string';
        $nullable = $fieldMapping['nullable'] ?? false;
        
        // Sometimes return null for nullable fields
        if ($nullable && $this->generator->boolean(20)) {
            return null;
        }

        switch ($type) {
            case 'integer':
            case 'smallint':
            case 'bigint':
                return $this->generator->numberBetween(1, 1000);
                
            case 'float':
            case 'decimal':
                return $this->generator->randomFloat(2, 0, 1000);
                
            case 'boolean':
                return $this->generator->boolean();
                
            case 'date':
                return $this->generator->date();
                
            case 'datetime':
            case 'datetime_immutable':
                return $this->generator->dateTime();
                
            case 'time':
                return $this->generator->time();
                
            case 'string':
                $length = $fieldMapping['length'] ?? 255;
                return $this->generator->text(min($length, 200));
                
            case 'text':
                return $this->generator->text(200);
                
            case 'json':
                return $this->generator->randomElements(['a', 'b', 'c'], 2);
                
            default:
                return $this->generator->word;
        }
    }

    /**
     * Generate random association value
     *
     * @param array $assocMapping
     * @return mixed
     */
    protected function generateAssociationValue(array $assocMapping)
    {
        $targetEntity = $assocMapping['targetEntity'];
        
        // For ManyToOne or OneToOne, return a single entity
        if ($assocMapping['type'] === ClassMetadata::MANY_TO_ONE || 
            $assocMapping['type'] === ClassMetadata::ONE_TO_ONE) {
            return $this->getRandomEntity($targetEntity);
        }
        
        // For OneToMany or ManyToMany, return an array of entities
        return [$this->getRandomEntity($targetEntity)];
    }

    /**
     * Get a random existing entity or create a new one
     *
     * @param string $entityClass
     * @return Entity
     */
    protected function getRandomEntity(string $entityClass): Entity
    {
        $repository = DB::getEntityManager()->getRepository($entityClass);
        $existing = $repository->findAll();
        
        if (!empty($existing) && $this->generator->boolean(70)) {
            return $this->generator->randomElement($existing);
        }
        
        // Create new entity if none exist or with 30% chance
        return $this->entity($entityClass);
    }
}