<?php

namespace App\Authentication\Services;

use App\Authentication\Entities\Role;
use Axiom\Application\Base\ResourceTrait;
use Axiom\Application\Base\Service;


/**
 * Service layer for domain business logic
 *
 * Handles all business logic operations related to Entities.
 * Serves as an intermediary between controllers and the data access layer (Doctrine entities).
 * 
 * @package App\Authentication\Services
 */
class RoleService extends Service
{
    use ResourceTrait;
     /**
     * @var The Doctrine entity class this service manages
     */
    protected $entity = Role::class;



    public function index()
    {
        dd($this->getEntityInstance()->getFillables());
    }
}