<?php

namespace Axiom\Traits;

/**
 * Trait InstanceTrait
 *
 * Provides instance management for classes.
 * Allows classes to store and retrieve a single instance, but does not enforce singleton behavior.
 */
trait InstanceTrait
{
    /**
     * The stored instance of the class.
     *
     * @var self|null
     */
    private static ?self $instance = null;

    /**
     * Set the instance.
     *
     * @param self $instance The instance to store.
     * @return self The stored instance.
     */
    public static function setInstance(self $instance): self
    {
        return self::$instance = $instance;
    }

    /**
     * Get the stored instance.
     *
     * If no instance is stored, it creates a new one.
     *
     * @return self The stored instance.
     */
    public static function getInstance(): self
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Clear the stored instance.
     *
     * @return void
     */
    public static function clearInstance(): void
    {
        self::$instance = null;
    }
}