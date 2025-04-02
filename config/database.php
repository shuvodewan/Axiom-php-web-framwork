<?php

// Database connection configs

return [
    'default'=>env('DEFAULT_DATABASE','mysql'),

    'mysql'=>[
        'driver'=>'pdo_mysql',
        'host'=>env('DB_HOST','127.0.0.1'),
        'port'=>env('DB_PORT',3306),
        'database'=>env('DB_DATABASE',''),
        'username'=>env('DB_USERNAME',''),
        'password'=>env('DB_PASSWORD','')
    ]
];