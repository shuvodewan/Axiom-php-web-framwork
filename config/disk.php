<?php

return [
    'default'=>env('UPLOAD_DISK','local'),
    'local'=>[
        'path'=>storage_path('/app'),
        'prefix'=>'',
        'url'=>''
    ],

    'public'=>[
        'path'=>public_path('/storage'),
        'prefix'=>'storage',
        'url'=>env('APP_URL','http://localhost:800')
    ],
];
