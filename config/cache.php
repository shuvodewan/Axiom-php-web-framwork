<?php

return [
    'default' => env('CACHE_DEFAULT_DRIVER', 'file'),

    // Redis connection settings
    'redis' => [
        'host'     => env('REDIS_HOST', '127.0.0.1'),
        'port'     => env('REDIS_PORT', 6379),
        'database' => env('REDIS_DATABASE', 0),
        'password' => env('REDIS_PASSWORD', null),
        'timeout'  => env('REDIS_TIMEOUT', 1.0),
        'persistent' => env('REDIS_PERSISTENT', false),
    ],
];
