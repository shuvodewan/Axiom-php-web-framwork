<?php

namespace Axiom\Http;

use Closure;

/**
 * Middleware contract.
 *
 * This interface defines the contract for middleware classes, ensuring they implement
 * a `handle` method to process incoming requests and pass them to the next middleware or handler.
 */
interface MiddlewareContract
{
    /**
     * Handles the incoming request.
     *
     * Middleware classes should implement this method to process the request and
     * optionally pass it to the next middleware or handler in the pipeline.
     *
     * @param Request $request The incoming HTTP request.
     * @param Closure $next The next middleware or handler in the pipeline.
     */
    public static function handle(Request $request, Closure $next);
}