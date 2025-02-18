<?php

namespace Core\traits;

use Dotenv\Dotenv;

trait EnvironmentTrait
{

    private function loadEnv(){
        $dotenv = Dotenv::createImmutable(base_path());
        $dotenv->safeLoad();
        return $this;
    }

    public function getEnv($key){
        return isset($_ENV[$key])?$_ENV[$key]:null;
    }
}