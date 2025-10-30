<?php

namespace Axiom\Project\Middlewares;

use Axiom\Application\MiddlewareRegistry;

/**
 * Middleware registration and retrieval class.
 *
 * This class provides a centralized way to register middleware aliases and retrieve
 * middleware classes or groups by their alias.
 */
class Register extends MiddlewareRegistry
{
    /** @var array A map of middleware aliases and their corresponding classes or groups. */
    protected static array $middlewares = [
        'web' => [
            StartSessionMiddleware::class,
            CsrfProtectionMiddleware::class,
        ],
        'guest' => GuestMiddleware::class,
        'auth' => AuthMiddleware::class,
    ];
}