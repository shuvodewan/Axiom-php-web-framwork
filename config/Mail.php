<?php

return [
    // Default mail driver (supported: "smtp", "mailgun", "sendmail")
    'default' => env('MAIL_DRIVER', 'smtp'),
    
    // Global email settings
    'global' => [
        'from' => [
            'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
            'name' => env('MAIL_FROM_NAME', 'Example'),
        ],
        'queue' => env('MAIL_QUEUE', 'emails'),
    ],

    // Driver configurations
    'drivers' => [
        'smtp' => [
            'host' => env('MAIL_SMTP_HOST', 'smtp.mailgun.org'),
            'port' => env('MAIL_SMTP_PORT', 587),
            'encryption' => env('MAIL_SMTP_ENCRYPTION', 'tls'),
            'username' => env('MAIL_SMTP_USERNAME'),
            'password' => env('MAIL_SMTP_PASSWORD'),
            'timeout' => env('MAIL_SMTP_TIMEOUT', 30),
            'local_domain' => env('MAIL_SMTP_LOCAL_DOMAIN'),
            'auth_mode' => env('MAIL_SMTP_AUTH_MODE'),
            'verify_peer' => env('MAIL_SMTP_VERIFY_PEER', true),
        ],
        
        'mailgun' => [
            'domain' => env('MAIL_MAILGUN_DOMAIN'),
            'secret' => env('MAIL_MAILGUN_SECRET'),
            'endpoint' => env('MAIL_MAILGUN_ENDPOINT', 'api.mailgun.net'),
            'scheme' => env('MAIL_MAILGUN_SCHEME', 'https'),
            'api_version' => env('MAIL_MAILGUN_API_VERSION', 'v3'),
        ],
        
        'sendmail' => [
            'path' => env('MAIL_SENDMAIL_PATH', '/usr/sbin/sendmail'),
            'args' => env('MAIL_SENDMAIL_ARGS', '-bs'),
            'timeout' => env('MAIL_SENDMAIL_TIMEOUT', 60),
        ],
    ],

    // Additional options
    'options' => [
        'debug' => env('MAIL_DEBUG', false),
        'charset' => env('MAIL_CHARSET', 'UTF-8'),
        'auto_text' => env('MAIL_AUTO_TEXT', true),
        'auto_tls' => env('MAIL_AUTO_TLS', true),
    ],
];