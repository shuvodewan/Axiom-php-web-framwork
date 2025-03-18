<?php

namespace Axiom\Project\Middlewares;

/**
 * Middleware registration and retrieval class.
 *
 * This class provides a centralized way to register middleware aliases and retrieve
 * middleware classes or groups by their alias.
 */
class Register
{
    /** @var array A map of middleware aliases and their corresponding classes or groups. */
    private static array $middlewares = [
        'web' => [
            StartSessionMiddleware::class,
            CsrfProtectionMiddleware::class,
        ],
        'guest' => GuestMiddleware::class,
        'auth' => AuthMiddleware::class,
    ];

    /**
     * Retrieves middleware by its alias.
     *
     * @param string $alias The middleware alias (e.g., 'web', 'guest', 'auth').
     * @return array|string|null The middleware class or group, or null if the alias is not found.
     */
    public static function getMiddleware(string $alias): array|string|null
    {
        return self::$middlewares[$alias] ?? null;
    }
}