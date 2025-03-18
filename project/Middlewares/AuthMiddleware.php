<?php

namespace Axiom\Project\Middlewares;

use Axiom\Http\MiddlewareContract;
use Axiom\Http\Request;
use Axiom\Http\Response;
use Axiom\Support\Facades\Auth;
use Closure;

/**
 * Middleware to restrict access to authenticated users.
 *
 * This middleware checks if the user is authenticated. If the user is not authenticated,
 * it redirects them to the login page with an error message. Otherwise, it allows the request
 * to proceed to the next middleware or handler.
 */
class AuthMiddleware implements MiddlewareContract
{
    /**
     * Handles the incoming request.
     *
     * Checks if the user is authenticated. If not authenticated, redirects to the login page
     * with an error message. Otherwise, passes the request to the next middleware or handler.
     *
     * @param Request $request The incoming HTTP request.
     * @param Closure $next The next middleware or handler in the pipeline.
     * @return mixed The response from the next middleware or handler.
     */
    public static function handle(Request $request, Closure $next): mixed
    {
        if (!Auth::id()) {
            session()->set('error', 'Please login to continue.');
            (new Response())->redirect('/auth/login')->send();
            return null; 
        }
        return $next($request);
    }
}