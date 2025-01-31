<?php

use Facade\Str;

return [

    'lifetime' => env('SESSION_LIFETIME', 43200),
    'expire_on_close' => true,
    'encrypt' => false,
    'cookie' => env(
        'SESSION_COOKIE',
        Str::toSlug(env('APP_NAME', 'test'), '_').'_session'
    ),
    'path' => '/',
    'domain' => env('SESSION_DOMAIN', null),
    'secure' => env('SESSION_SECURE_COOKIE', null),
    'http_only' => true,
    'same_site' => null,
];
