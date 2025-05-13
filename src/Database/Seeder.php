<?php

namespace Axiom\Database;

use Axiom\Console\Preview;
use Faker\Factory;

/**
 * Abstract Seeder class to provide base functionality for generating fake data
 * using the Faker library. This class should be extended by other seeders
 * to implement the `call()` method which will handle seeding specific data.
 * 
 * The constructor initializes the Faker instance that can be used in child classes
 * to generate fake data for database seeding or testing purposes.
 */
abstract class Seeder
{
    /**
     * @var \Faker\Generator Instance of the Faker generator used to create fake data.
     */
    protected $faker;

    /**
     * Seeder constructor.
     * Initializes the Faker instance that will be used for generating fake data.
     */
    public function __construct()
    {
        $this->faker = Factory::create();  // Create an instance of Faker to generate fake data
    }


    /**
     * Dynamically instantiate and execute a seeder class.
     *
     * This method accepts the fully qualified class name of a seeder,
     * creates an instance, runs the seeder, and displays progress messages.
     *
     * @param string $seeder The fully qualified class name of the seeder to run.
     * 
     * @return void
     */
    public function call($seeder){
        $seeder = new $seeder();

        Preview::warn(get_class($seeder) . ' Seeding...............');
        $seeder->run();
        Preview::green(get_class($seeder) . ' Seeding Completed');
    }

    /**
     * Abstract method that must be implemented by child classes.
     * This method should contain the logic for seeding specific database data
     * using the Faker instance or other methods.
     *
     * @return void
     */
    abstract public function run();
}