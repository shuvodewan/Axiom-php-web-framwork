<?php

namespace Core\traits;

use Core\support\Database;

trait ValidatorRules
{

    protected function validateRequired($field, $value)
    {
        if (empty($value) && !isset($this->files[$field])) {
            $this->addError($field, "$field is required.");
        }
    }

    protected function validateEmail($field, $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, "$field must be a valid email.");
        }
    }

    protected function validateUnique($field, $value, $params)
    {
        if ($value && (new Database())->isUnique($params, $field, $value)) {
            $this->addError($field, "$field already exists.");
        }
    }

    protected function validateMin($field, $value, $params)
    {
        if (strlen($value) < $params) {
            $this->addError($field, "$field must be at least $params characters.");
        }
    }

    protected function validateMax($field, $value, $params)
    {
        if (strlen($value) > $params) {
            $this->addError($field, "$field may not be greater than $params characters.");
        }
    }

    protected function validateRegex($field, $value, $params)
    {
        if (!preg_match($params, $value)) {
            $this->addError($field, "$field has an invalid format.");
        }
    }

   
    protected function validateMatch($field, $value, $params)
    {
        if (!isset($this->data[$params])) {
            $this->addError($field, "$params is required.");
            return;
        }

        if ($value !== $this->data[$params]) {
            $this->addError($field, "$field must match with $params.");
        }
    }

   
    protected function validateMimes($field, $params)
    {
        $types = explode(',', $params);

        if (!isset($this->files[$field])) {
            $this->addError($field, "$field must be a file of type: " . implode(', ', $types) . ".");
        }

        $fileType = explode('/', $this->files[$field]->type)[1];
        if (!in_array($fileType, array_map('trim', $types))) {
            $this->addError($field, "$field must be a file of type: " . implode(', ', $types) . ".");
        }
    }


    protected function validateFileMax($field, $params)
    {
        if (!isset($this->files[$field])) {
            $this->addError($field, "$field must be a file.");
        }

        $max = (int)$params * 1024;
        if ($this->files[$field]->size > $max) {
            $this->addError($field, "$field must not be larger than $params KB.");
        }
    }

   
    protected function validateFileMin($field, $params)
    {
        if (!isset($this->files[$field])) {
            $this->addError($field, "$field must be a file.");
        }

        $minSize = (int)$params * 1024;
        if ($this->files[$field]->size < $minSize) {
            $this->addError($field, "$field must be at least $params KB.");
        }
    }

    protected function validateIn($field, $value, $params)
    {
        $allowedValues = explode(',', $params);

        if (!in_array($value, array_map('trim', $allowedValues))) {
            $this->addError($field, "$field must be one of the following: " . implode(', ', $allowedValues) . ".");
        }
    }

}