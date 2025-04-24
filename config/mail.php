<?php

return [
    'default' => env('MAIL_DRIVER', 'smtp'),
    
    'drivers' => [
        'smtp' => [
            'host' => env('MAIL_HOST', 'smtp.mailtrap.io'),
            'port' => env('MAIL_PORT', 2525),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'auth_mode' => null,
        ],
        
        'mailgun' => [
            'domain' => env('MAILGUN_DOMAIN'),
            'secret' => env('MAILGUN_SECRET'),
            'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
            'region' => env('MAILGUN_REGION', 'us'), // 'us' or 'eu'
        ],
        
        'sendmail' => [
            'path' => env('MAIL_SENDMAIL_PATH', '/usr/sbin/sendmail'),
            'args' => env('MAIL_SENDMAIL_ARGS', '-t -i'),
        ],

        'postmark' => [
            'token' => env('POSTMARK_TOKEN'),
        ],
    ],
    
    'global' => [
        'from' => [
            'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
            'name' => env('MAIL_FROM_NAME', 'Example'),
        ],
    ],
];