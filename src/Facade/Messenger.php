<?php

namespace Axiom\Facade;

use Axiom\Messenger\MessageManager;

/**
 * Str Facade
 *
 * Provides a static interface to the `SupportStr` class for string manipulation utilities.
 * This facade allows convenient access to string-related methods without needing to
 * manually instantiate the `SupportStr` class.
 */
class Messenger implements FacadeContract
{
    use FacadeTrait;

    /**
     * Get the singleton instance of the `MessageManager` class.
     *
     * If the instance does not exist, it is created. Subsequent calls will return
     * the same instance.
     *
     * @return MessageManager The singleton instance of `SupportStr`
     */
    public static function getInstance() :MessageManager
    {
        if (!isset(self::$instance)) {
            self::$instance = new MessageManager();
        }

        return self::$instance;
    }
}