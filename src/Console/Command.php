<?php

namespace Axiom\Console;

use Axiom\Http\Validator;
use Exception;

/**
 * Command Class
 *
 * Abstract base class for console commands.
 * Provides functionality for parsing arguments, validating input, and rendering output.
 */
abstract class Command
{
    /** @var array The parsed command arguments */
    protected array $arguments = [];

    /** @var array The parsed command options */
    protected array $options = [];

    /**
     * Handle the command execution.
     *
     * This method must be implemented by concrete command classes.
     *
     * @return void
     */
    abstract public function handle(): void;

    /**
     * Define validation rules for command arguments.
     *
     * This method must be implemented by concrete command classes.
     *
     * @return array The validation rules
     */
    abstract protected function validator(): array;

    /**
     * Parse command-line arguments and options.
     *
     * @param array $args The raw command-line arguments
     * @return array The parsed arguments and options
     */
    protected function parseArguments(array $args): array
    {
        $data = [];

        foreach ($args as $arg) {
            if (preg_match('/^(?:--([\w-]+)(?:=(.*))?|[\w\d]+)$/', $arg, $matches)) {
                if (!empty($matches[1])) {
                    $option = $matches[1];
                    $value = $matches[2] ?? true;
                    $data[$option] = $value;
                } else {
                    $data[$arg] = true;
                }
            }
        }

        return $data;
    }

    /**
     * Set and validate command arguments.
     *
     * @param array $args The raw command-line arguments
     * @return $this
     * @throws Exception If validation fails
     */
    public function setArguments(array $args): self
    {
        $data = $this->parseArguments($args);
        $validator = new Validator($data, $this->validator());

        if (!$validator->validate()) {
            $validator->setToResponse();
            throw new Exception('Failed to execute command!');
        }

        $this->arguments = $data;
        return $this;
    }

    /**
     * Get the value of a command argument.
     *
     * @param string $name The name of the argument
     * @return mixed The argument value or null if not found
     */
    public function argument(string $name)
    {
        return $this->arguments[$name] ?? null;
    }

  /**
     * Handle dynamic method calls and delegate them to the Preview class.
     *
     * This allows calling Preview methods directly on the Command instance.
     *
     * @param string $method The method name
     * @param array $args The method arguments
     * @return mixed The result of the Preview method call
     */
    public function __call(string $method, array $args)
    {
        return Preview::$method(...$args);
    }
}
