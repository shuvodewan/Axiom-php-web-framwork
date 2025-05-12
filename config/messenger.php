<?php

return [
    'default_transport' => env('MESSENGER_TRANSPORT', 'doctrine'),

    'transports' => [
        'sync' => [
            'dsn' => 'sync://'
        ],
        
        'amqp' => [
            'dsn' => env('AMQP_DSN', 'amqp://guest:guest@localhost:5672/%2f/messages'),
            'options' => [
                'exchange' => [
                    'name' => 'messages',
                    'type' => 'direct',
                ],
                'queues' => [
                    'high_priority' => [
                        'binding_keys' => ['high']
                    ]
                ]
            ]
        ],
        
        'doctrine' => [
            'dsn' => 'doctrine://default',
            'options' => [
                'table_name' => 'messenger_messages',
                'queue_name' => 'default',
                'redeliver_timeout' => 3600,
                'auto_setup' => false,
            ]
        ],
        
        'redis' => [
            'dsn' => env('REDIS_DSN', 'redis://localhost:6379/messages'),
            'options' => [
                'stream' => 'messages',
                'group' => 'workers',
                'consumer' => 'consumer1',
                'delete_after_ack' => true,
            ]
        ],
        
        'sqs' => [
            'dsn' => env('SQS_DSN', 'sqs://key:secret@default'),
            'options' => [
                'region' => env('AWS_REGION', 'us-east-1'),
                'queue_name' => 'messages',
                'access_key' => env('AWS_ACCESS_KEY'),
                'secret_key' => env('AWS_SECRET_KEY'),
            ]
        ],
        
        'failed' => [
            'dsn' => 'doctrine://default?queue_name=failed',
            'options' => [
                'table_name' => 'messenger_messages_failed',
                'connection' => env('DATABASE_CONNECTION', 'mysql'), // Same connection
                'connection_options' => [
                    'dbname' => env('DB_DATABASE', 'forge'),
                    'user' => env('DB_USERNAME', 'forge'),
                    'password' => env('DB_PASSWORD', ''),
                    'host' => env('DB_HOST', '127.0.0.1'),
                    'port' => env('DB_PORT', 3306)
                ]
            ]
        ]
    ],
    
    'retry_strategy' => [
        'max_retries' => 3,
        'delay' => 1000,
        'multiplier' => 2,
        'max_delay' => 0,
    ],
    
    'worker' => [
        'sleep_on_empty' => 1000,
        'memory_limit' => 128,
        'time_limit' => 3600,
    ]
];