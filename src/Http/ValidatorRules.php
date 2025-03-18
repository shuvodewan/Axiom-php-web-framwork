<?php

namespace Axiom\Http;

use Core\support\Database;

trait ValidatorRules
{
    protected array $errors = [];
    protected array $data = [];
    protected array $files = [];

    /**
     * Validate that a field is required.
     *
     * @param string $field
     * @param mixed $value
     * @return void
     */
    protected function validateRequired(string $field, $value): void
    {
        if (empty($value) && !isset($this->files[$field])) {
            $this->addError($field, "$field is required.");
        }
    }

    /**
     * Validate that a field is a valid email address.
     *
     * @param string $field
     * @param string $value
     * @return void
     */
    protected function validateEmail(string $field, string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, "$field must be a valid email.");
        }
    }

    /**
     * Validate that a field is unique in the database.
     *
     * @param string $field
     * @param string $value
     * @param string $params
     * @return void
     */
    protected function validateUnique(string $field, string $value, string $params): void
    {
        if ($value && (new Database())->isUnique($params, $field, $value)) {
            $this->addError($field, "$field already exists.");
        }
    }

    /**
     * Validate that a field meets a minimum length requirement.
     *
     * @param string $field
     * @param string $value
     * @param int $params
     * @return void
     */
    protected function validateMin(string $field, string $value, int $params): void
    {
        if (strlen($value) < $params) {
            $this->addError($field, "$field must be at least $params characters.");
        }
    }

    /**
     * Validate that a field does not exceed a maximum length.
     *
     * @param string $field
     * @param string $value
     * @param int $params
     * @return void
     */
    protected function validateMax(string $field, string $value, int $params): void
    {
        if (strlen($value) > $params) {
            $this->addError($field, "$field may not be greater than $params characters.");
        }
    }

    /**
     * Validate that a field matches a regular expression.
     *
     * @param string $field
     * @param string $value
     * @param string $params
     * @return void
     */
    protected function validateRegex(string $field, string $value, string $params): void
    {
        if (!preg_match($params, $value)) {
            $this->addError($field, "$field has an invalid format.");
        }
    }

    /**
     * Validate that a field matches another field.
     *
     * @param string $field
     * @param string $value
     * @param string $params
     * @return void
     */
    protected function validateMatch(string $field, string $value, string $params): void
    {
        if (!isset($this->data[$params])) {
            $this->addError($field, "$params is required.");
            return;
        }

        if ($value !== $this->data[$params]) {
            $this->addError($field, "$field must match with $params.");
        }
    }

    /**
     * Validate that a file is of a specific MIME type.
     *
     * @param string $field
     * @param string $params
     * @return void
     */
    protected function validateMimes(string $field, string $params): void
    {
        $types = explode(',', $params);

        if (!isset($this->files[$field])) {
            $this->addError($field, "$field must be a file of type: " . implode(', ', $types) . ".");
            return;
        }

        $fileType = explode('/', $this->files[$field]->type)[1];
        if (!in_array($fileType, array_map('trim', $types))) {
            $this->addError($field, "$field must be a file of type: " . implode(', ', $types) . ".");
        }
    }

    /**
     * Validate that a file does not exceed a maximum size.
     *
     * @param string $field
     * @param int $params
     * @return void
     */
    protected function validateFileMax(string $field, int $params): void
    {
        if (!isset($this->files[$field])) {
            $this->addError($field, "$field must be a file.");
            return;
        }

        $max = $params * 1024;
        if ($this->files[$field]->size > $max) {
            $this->addError($field, "$field must not be larger than $params KB.");
        }
    }

    /**
     * Validate that a file meets a minimum size requirement.
     *
     * @param string $field
     * @param int $params
     * @return void
     */
    protected function validateFileMin(string $field, int $params): void
    {
        if (!isset($this->files[$field])) {
            $this->addError($field, "$field must be a file.");
            return;
        }

        $minSize = $params * 1024;
        if ($this->files[$field]->size < $minSize) {
            $this->addError($field, "$field must be at least $params KB.");
        }
    }

    /**
     * Validate that a field's value is in a list of allowed values.
     *
     * @param string $field
     * @param string $value
     * @param string $params
     * @return void
     */
    protected function validateIn(string $field, string $value, string $params): void
    {
        $allowedValues = explode(',', $params);

        if (!in_array($value, array_map('trim', $allowedValues))) {
            $this->addError($field, "$field must be one of the following: " . implode(', ', $allowedValues) . ".");
        }
    }

    /**
     * Add an error message for a field.
     *
     * @param string $field
     * @param string $message
     * @return void
     */
    protected function addError(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }

    /**
     * Check if there are any validation errors.
     *
     * @return bool
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    /**
     * Get all validation errors.
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}