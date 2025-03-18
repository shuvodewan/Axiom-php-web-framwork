<?php

namespace Axiom\Console;

use Axiom\Traits\InstanceTrait;
use League\CLImate\CLImate;

/**
 * Preview Class
 *
 * Provides a static interface to the CLImate library for console output.
 * This class allows convenient access to CLImate methods without needing to
 * manually instantiate the CLImate class.
 */
class Preview
{
    use InstanceTrait;

    /** @var CLImate The CLImate instance */
    protected CLImate $climate;

    /**
     * Preview Constructor
     *
     * Initializes the CLImate instance.
     */
    public function __construct()
    {
        $this->climate = new CLImate();
    }

    /**
     * Handle static method calls and delegate them to the CLImate instance.
     *
     * @param string $method The method name
     * @param array $args The method arguments
     * @return mixed
     */
    public static function __callStatic(string $method, array $args)
    {
        return self::getInstance()->climate->$method(...$args);
    }
}