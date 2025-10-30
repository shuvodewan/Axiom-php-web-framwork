<?php

namespace App\Authentication\Seeders;

use App\Authentication\Entities\Permission;
use App\Authentication\Entities\Role;
use Axiom\Database\Seeder;
use Axiom\Facade\Str;

class RoleSeeder  extends Seeder
{
     /**
     * The run method is used to define the seeding logic .
     * either by using  Entity or queries, depending on your requirements.
     * 
     * $this->faker to generate fake data" 
     * @return void
     */
    public function run(){
        $permissions = Permission::findAll();

        $super = Role::updateOrCreate(['title' => 'Super','slug'=>Str::toSlug('Super')]);
        $super->syncPermissions($permissions);

        $super = Role::updateOrCreate(['title' => 'User','slug'=>Str::toSlug('User')]);
    }
}