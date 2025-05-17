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

        // Authorization management
        $moduleAuthorization = Module::updateOrCreate(['title' => 'Authorization','slug'=>Str::toSlug('Authorization')]);
        $permission = Permission::updateOrCreate([
            'title' => 'Select Roles',
            'slug' => 'roles.select',
        ]);
        
    }
}