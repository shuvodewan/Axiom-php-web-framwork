<?php

namespace App\Authentication\Seeders;

use App\Authentication\Entities\Role;
use App\Authentication\Entities\User;
use Axiom\Database\Seeder;
use Axiom\Facade\Hash;

class UserSeeder  extends Seeder
{
     /**
     * The run method is used to define the seeding logic .
     * either by using  Entity or queries, depending on your requirements.
     * 
     * $this->faker to generate fake data" 
     * @return void
     */
    public function run(){
        $superRole= Role::where('slug','super')->first(); 
        $userRole= Role::where('slug','user')->first(); 


        $super = User::updateOrCreate(
            ['name'=>'Super','user_name'=>'super','email'=>'super@mail.com'],
            ['password'=>Hash::make('password'),'roles'=>$superRole]
        );

        $user = User::updateOrCreate(
            ['name'=>'User','user_name'=>'user','email'=>'user@mail.com'],
            ['password'=>Hash::make('password'),'roles'=>$userRole]
        );
        
    }
}