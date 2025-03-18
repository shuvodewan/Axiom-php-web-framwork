<?php

namespace Axiom\Facade;

use Axiom\Core\Log as CoreLog;

/**
 * Log Facade
 *
 * Provides a static interface to the `CoreLog` class for logging functionality.
 * This facade allows convenient access to logging methods without needing to
 * manually instantiate the `CoreLog` class.
 */
class Log implements FacadeContract
{
    use FacadeTrait;

    /**
     * Get the underlying instance of the `CoreLog` class.
     *
     * @return CoreLog The singleton instance of `CoreLog`
     */
    public static function getInstance(): CoreLog
    {
        return CoreLog::getInstance();
    }
}