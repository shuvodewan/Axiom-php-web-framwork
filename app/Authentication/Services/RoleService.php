<?php

namespace App\Authentication\Services;

use App\Authentication\Entities\Module;
use App\Authentication\Entities\Permission;
use App\Authentication\Entities\Role;
use Axiom\Application\Base\ResourceTrait;
use Axiom\Application\Base\Service;
use Axiom\Facade\Str;

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
     /**
     * @var The Doctrine entity class this service manages
     */
    protected $entity = Role::class;


    public function index(){  
        $moduleAuthorization = Module::updateOrCreate(['title' => 'Authorization','slug'=>Str::toSlug('Authorization')]);
        $permission = Permission::new([
            'title' => 'Select Roles',
            'slug' => 'roles.select',
        ])->addModule($moduleAuthorization);
    }

}