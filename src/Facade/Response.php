<?php

namespace Axiom\Facade;

use Axiom\Http\Response as res;

/**
 * Response Facade
 *
 * Provides a static interface to the underlying `HttpResponse` instance.
 * This facade allows convenient access to HTTP response methods without
 * needing to manually resolve the `HttpResponse` instance.
 */
class Response implements FacadeContract
{
    use FacadeTrait;

    /**
     * Get the underlying `HttpResponse` instance.
     *
     * This method resolves and returns the singleton instance of the `HttpResponse` class.
     * If the instance cannot be resolved, a `RuntimeException` is thrown.
     *
     * @return HttpResponse The underlying `HttpResponse` instance
     * @throws \RuntimeException If the `HttpResponse` instance cannot be resolved
     */
    public static function getInstance(): res
    {
        return new res();
    }
}