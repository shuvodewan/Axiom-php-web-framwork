<?php

namespace App\Authentication\Seeders;

use App\Authentication\Entities\Module;
use App\Authentication\Entities\Permission;
use Axiom\Database\Seeder;
use Axiom\Facade\Str;

class PermissionSeeder  extends Seeder
{
     /**
     * The run method is used to define the seeding logic .
     * either by using  Entity or queries, depending on your requirements.
     * 
     * $this->faker to generate fake data" 
     * @return void
     */
    public function run(){

        // Role management
        $moduleAppRole = Module::updateOrCreate([
            'title' => 'Role Management',
            'slug' => Str::toSlug('Role Management')
        ]);

        Permission::updateOrCreate([
            'title' => 'Access Roles',
            'slug' => 'app.roles.index',
            'module' => $moduleAppRole
        ]);

        Permission::updateOrCreate([
            'title' => 'Create Role',
            'slug' => 'app.roles.create',
            'module' => $moduleAppRole
        ]);

        Permission::updateOrCreate([
            'title' => 'Edit Role',
            'slug' => 'app.roles.edit',
            'module' => $moduleAppRole
        ]);

        Permission::updateOrCreate([
            'title' => 'Delete Role',
            'slug' => 'app.roles.destroy',
            'module' => $moduleAppRole
        ]);


        // User management
        $moduleAppUser = Module::updateOrCreate([
            'title' => 'User Management',
            'slug' => Str::toSlug('User Management')
        ]);

        Permission::updateOrCreate([
            'title' => 'Access Users',
            'slug' => 'app.users.index',
            'module' => $moduleAppUser
        ]);

        Permission::updateOrCreate([
            'title' => 'Create User',
            'slug' => 'app.users.create',
            'module' => $moduleAppUser
        ]);

        Permission::updateOrCreate([
            'title' => 'Edit User',
            'slug' => 'app.users.edit',
            'module' => $moduleAppUser
        ]);

        Permission::updateOrCreate([
            'title' => 'Delete User',
            'slug' => 'app.users.destroy',
            'module' => $moduleAppUser
        ]);
        
    }
}