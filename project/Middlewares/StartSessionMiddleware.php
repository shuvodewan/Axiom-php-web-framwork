<?php

namespace Axiom\Project\Middlewares;

use Axiom\Http\MiddlewareContract;
use Axiom\Http\Session;
use Axiom\Http\Request;
use Closure;

/**
 * Middleware to start a session.
 *
 * This middleware initializes the session before processing the request.
 */
class StartSessionMiddleware implements MiddlewareContract
{
    /**
     * Handles the incoming request.
     *
     * Starts the session and passes the request to the next middleware or handler.
     *
     * @param Request $request The incoming HTTP request.
     * @param callable $next The next middleware or handler in the pipeline.
     * @return mixed The response from the next middleware or handler.
     */
    public static function handle(Request $request, Closure $next)
    {
        (new Session())->startSession();
        return $next($request);
    }
}