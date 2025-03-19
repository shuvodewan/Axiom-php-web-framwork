<?php

return [
    'name'=>env('APP_NAME','Application'),
    'url'=>env('APP_URL','http://localhost'),
    'key'=>env('APP_KEY'),
    'hash_cost'=>10,
    'debug'=>env('APP_DEBUG'),
    'mode'=>env('APP_MODE'),
    'route_closure'=>env('APP_ROUTE_CLOSURE',true),
    'csrf_expire_time'=>env('CSRF_EXPIRE_TIME',5),

    //

    'applications'=>[
    ]
];
