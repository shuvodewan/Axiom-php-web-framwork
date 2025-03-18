<?php

namespace Axiom\Project\Middlewares;

use Axiom\Http\MiddlewareContract;
use Axiom\Http\Request;
use Carbon\Carbon;
use Exception;
use Closure;

/**
 * Middleware for CSRF protection.
 *
 * This middleware ensures that POST requests include a valid CSRF token to prevent
 * cross-site request forgery attacks.
 */
class CsrfProtectionMiddleware implements MiddlewareContract
{
    /**
     * Handles the incoming request.
     *
     * Validates the CSRF token for POST requests. If the token is missing or invalid,
     * an exception is thrown. Otherwise, the request is passed to the next middleware or handler.
     *
     * @param Request $request The incoming HTTP request.
     * @param Closure $next The next middleware or handler in the pipeline.
     * @return mixed The response from the next middleware or handler.
     * @throws Exception If the CSRF token is missing or invalid.
     */
    public static function handle(Request $request, Closure $next): mixed
    {
        if ($request->method === 'POST') {
            $token = self::getCsrfToken($request);

            if (!$token || !self::verifyCsrf($token)) {
                throw new Exception('Page Expired');
            }
        }

        return $next($request);
    }

    /**
     * Retrieves the CSRF token from the request.
     *
     * The token is first checked in the headers (`x-csrf-token`), and if not found,
     * it is checked in the request body (`csrf_token`).
     *
     * @param Request $request The incoming HTTP request.
     * @return string|null The CSRF token, or null if not found.
     */
    private static function getCsrfToken(Request $request): ?string
    {
        return $request->getHeader('x-csrf-token') ?? $request->getBody('csrf_token');
    }

    /**
     * Verifies the CSRF token.
     *
     * Checks if the provided token matches the token stored in the session and if it has not expired.
     *
     * @param string $token The CSRF token to verify.
     * @return bool True if the token is valid, false otherwise.
     */
    private static function verifyCsrf(string $token): bool
    {
        $csrfToken = session()->get('csrf_token');

        if (!$csrfToken) {
            return false;
        }

        return hash_equals($csrfToken['token'], $token) &&
               Carbon::now()->lessThan(Carbon::parse($csrfToken['expire_at']));
    }
}