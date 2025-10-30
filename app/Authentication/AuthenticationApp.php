<?php

namespace App\Authentication;

use App\Authentication\Seeders\PermissionSeeder;
use App\Authentication\Seeders\RoleSeeder;
use App\Authentication\Seeders\UserSeeder;
use App\Authentication\Transports\Handlers\MailHandler;
use App\Authentication\Transports\Jobs\MailJob;
use Axiom\Application\App;

class AuthenticationApp extends App
{

    public bool $appRoute = true;

    public function registerJobs() :array
    {
        return [MailJob::class=>[ new MailHandler()]];
    }


     /**
     * An array of database seeder classes to run when seeding the application.
     * 
     * Seeders will be executed in the order they are defined in this array.
     *
     * @var array<class-string> Array of seeder class names
     */
    public array $seeders = [
        PermissionSeeder::class,
        RoleSeeder::class,
        UserSeeder::class,
    ];
}