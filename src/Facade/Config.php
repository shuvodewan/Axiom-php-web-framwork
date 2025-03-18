<?php

namespace Axiom\Facade;

use Axiom\Core\Config as CoreConfig;

/**
 * Config Facade
 *
 * Provides a static interface to the `CoreConfig` class for configuration management.
 * This facade allows convenient access to configuration methods without needing to
 * manually instantiate the `CoreConfig` class.
 */
class Config implements FacadeContract
{
    use FacadeTrait;

    /**
     * Get the underlying instance of the `CoreConfig` class.
     *
     * @return CoreConfig The singleton instance of `CoreConfig`
     */
    public static function getInstance(): CoreConfig
    {
        return CoreConfig::getInstance();
    }
}