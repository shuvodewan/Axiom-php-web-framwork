<?php

return [
    'default' => env('DATABASE_CONNECTION', 'mysql'),

    'connections' => [
        'mysql' => [
            'driver' => 'pdo_mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', 3306),
            'dbname' => env('DB_DATABASE', 'forge'),
            'user' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8mb4',
            'serverVersion' => env('DB_VERSION', '8.0'),
            'driverOptions' => [
                PDO::ATTR_PERSISTENT => false,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_STRINGIFY_FETCHES => false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ],
            'defaultTableOptions' => [
                'charset' => 'utf8mb4',
                'collate' => 'utf8mb4_unicode_ci',
            ],
        ],
        
        'sqlite' => [
            'driver' => 'pdo_sqlite',
            'path' => env('DB_DATABASE', database_path('database.sqlite')),
            'memory' => env('DB_MEMORY', false),
        ],
    ],

    'migrations' => [
        'table_storage' => [
            'table_name' => 'migrations',
            'version_column_name' => 'version',
            'version_column_length' => 191,
            'executed_at_column_name' => 'executed_at',
            'execution_time_column_name' => 'execution_time',
        ],
        'migrations_paths' => [
            'Database\Migrations' => database_path('/Migrations'),
        ],
        'all_or_nothing' => true,
        'check_database_platform' => true,
        'namespace'=>'Database\\Migrations',
    ],
];