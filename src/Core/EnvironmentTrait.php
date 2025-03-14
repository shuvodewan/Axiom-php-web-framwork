<?php

namespace Axiom\Core;

use Dotenv\Dotenv;

trait EnvironmentTrait
{
    /**
     * Load environment variables from the .env file into the application.
     *
     * This method uses the Dotenv library to load environment variables from the `.env` file
     * located in the base directory of the application. The variables are then made available
     * in the `$_ENV` and `$_SERVER` superglobals.
     *
     * @return self Returns the current instance for method chaining.
     */
    private function loadEnv(): self
    {
        $dotenv = Dotenv::createImmutable(base_path());
        $dotenv->safeLoad();
        return $this;
    }

    /**
     * Retrieve the value of an environment variable.
     *
     * This method checks if the specified environment variable exists and returns its value.
     * If the environment variable is not set, it returns `null`.
     *
     * @param string $key The key of the environment variable to retrieve.
     * @return string|null The value of the environment variable, or `null` if the variable is not set.
     */
    public function getEnv(string $key) :?string
    {
        return isset($_ENV[$key]) ? $_ENV[$key] : null;
    }
}
