<?php

namespace Axiom\Facade;

trait FacadeTrait
{
    /**
     * The underlying instance of the facade.
     *
     * @var object|null
     */
    protected static $instance;

    /**
     * Handle static method calls and delegate them to the underlying instance.
     *
     * @param string $name The method name
     * @param array $arguments The method arguments
     * @return mixed
     * @throws \BadMethodCallException If the method does not exist on the instance
     */
    public static function __callStatic(string $name, array $arguments)
    {
        $instance = static::getInstance();

        if (!is_object($instance)) {
            throw new \BadMethodCallException('No underlying instance found for the facade.');
        }

        if (!method_exists($instance, $name)) {
            throw new \BadMethodCallException("Method $name does not exist on the underlying instance.");
        }

        return $instance->$name(...$arguments);
    }

}