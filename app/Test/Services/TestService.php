<?php

namespace App\Test\Services;

use App\Test\Entities\Test;
use Axiom\Application\Base\Service;

class TestService extends Service
{
    protected $entity = Test::class;

    public function index()
    {
        return $features = [
            [
                'icon' => '<svg>...</svg>', 
                'title' => 'Eloquent ORM',
                'description' => 'Beautiful database abstraction'
            ],
        ];
    }
}