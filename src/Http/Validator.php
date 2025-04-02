<?php

namespace Axiom\Http;

use Axiom\Console\Preview;
use Axiom\Core\Application;

class Validator
{
    use ValidatorRules;

    /** @var array Static error bag for global error storage */
    public static array $errorsBag = [];

    /** @var array The data to validate */
    protected array $data = [];

    /** @var array The uploaded files to validate */
    protected array $files = [];

    /** @var array The validation rules */
    protected array $rules = [];

    /** @var array The validation errors */
    protected array $errors = [];

    /** @var array Terminate next field validation if required error add */
    protected bool $terminate = false;

    /**
     * Validator constructor.
     *
     * @param array|null $data The data to validate
     * @param array|null $rules The validation rules
     */
    public function __construct($data = null, ?array $rules = null)
    {
        $this->rules = $rules ?? [];

        if ($data) {
            $this->setData($data);
        }
    }

    /**
     * Set the data and files to validate.
     *
     * @param mixed $data The data to validate (can be an array or a Request object)
     * @return $this
     */
    public function setData($data): self
    {
        if (is_array($data)) {
            $this->data = $data;
            $this->files = [];
        } elseif (is_object($data) && method_exists($data, 'body') && method_exists($data, 'getFiles')) {
            $this->data = $data->body ?? [];
            $this->files = $data->getFiles() ?? [];
        } else {
            throw new \InvalidArgumentException('Data must be an array or a Request object.');
        }

        return $this;
    }

    /**
     * Validate the data against the rules.
     *
     * @return bool True if validation passes, false otherwise
     */
    public function validate(): bool
    {   
        foreach ($this->rules as $field => $rules) {
            $value = $this->data[$field] ?? null;
            $this->terminate=false;
            foreach (is_array($rules) ? $rules : explode('|', $rules) as $rule) {


                if($rule=='nullable' && !$value){
                    break ;
                }

                if (is_callable($rule)) {
                    $rule($field, $value ?? $this->files[$field], $this);
                } else {
                    $this->applyRule($field, $value, $rule);
                }

                if($this->terminate){
                    break;
                }
            }
        }

        return empty($this->errors);
    }

    /**
     * Apply a single validation rule to a field.
     *
     * @param string $field The field name
     * @param mixed $value The field value
     * @param string $rule The validation rule
     * @return void
     */
    protected function applyRule(string $field, $value, string $rule): void
    {
        $params = null;

        if (strpos($rule, ':') !== false) {
            [$rule, $params] = explode(':', $rule, 2);
        }

        $method = 'validate' . str_replace('_', '', ucwords($rule, '_'));

        if (method_exists($this, $method)) {
            $this->$method($field, $value, $params);

        } else {
            $this->addError($field, "Validation rule '$rule' does not exist.");
        }
    }

    /**
     * Add an error message for a field.
     *
     * @param string $field The field name
     * @param string $message The error message
     * @return void
     */
    public function addError(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }

    /**
     * Get all validation errors.
     *
     * @return array The validation errors
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * Set validation errors to the response.
     *
     * @return void
     */
    public function setToResponse(): void
    {
        if (Application::getInstance()->isConsole()) {
            foreach ($this->errors as $error) {
                Preview::error($error[0]);
            }
            return;
        }

        if (!empty($this->errors)) {
            (new Request())->isJsonResponse()
                ? self::$errorsBag = $this->errors
                : session()->set( (new Request())->getUri(), $this->errors);
        }
    }

    /**
     * Clear the static errors bag.
     *
     * @return void
     */
    public static function clearErrorsBag(): void
    {
        self::$errorsBag = [];
    }
}