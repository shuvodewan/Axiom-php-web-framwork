<?php

namespace App\Authentication\Services;

use App\Authentication\Entities\User;
use Axiom\Application\Base\Service;


/**
 * Service layer for domain business logic
 *
 * Handles all business logic operations related to Entities.
 * Serves as an intermediary between controllers and the data access layer (Doctrine entities).
 * 
 * @package App\Authentication\Services
 */
class UserService extends Service
{
     /**
     * @var The Doctrine entity class this service manages
     */
    protected $entity = User::class;



    public function index($data)
    {
        $this->entity->create($data);
    }
}