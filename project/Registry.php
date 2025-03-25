<?php

namespace Axiom\Project;

use App\Test\TestApp;

class Registry
{
    static $INSTALLED_APPS = [
        TestApp::class
    ];

    static $GROUPS = [
        'global'=>[
            'middlewares'=>['admin'],
            'prefix'=>'global'
        ]
    ];
}