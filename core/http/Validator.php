<?php

namespace Core\http;

use Core\Application;
use Core\console\Preview;
use Core\facade\Request;
use Core\traits\ValidatorRules;
use Exception;

class Validator
{
    use ValidatorRules;

    static $errorsBag = [];
    protected $data;
    protected $files;
    protected $rules;
    protected $errors = [];

    public function __construct($data=null, $rules=null)
    {
        $this->rules = $rules;

        if($data){
            $this->setData($data);
        }
    }

    public function setData($data){
        $this->data = is_array($data) ? $data : $data->body;
        $this->files = is_array($data) ? : $data->getFiles();
        return $this;
    }

    public function validate()
    {
        foreach ($this->rules as $field => $rules) {
            $value = $this->data[$field] ?? null;

            foreach (is_array($rules)?$rules:explode('|', $rules) as $rule) {
                if(is_callable($rule)){
                    $rule($field, $value??$this->files[$field], $this);
                }
                $this->applyRule($field, $value, $rule);
            }
        }

        return empty($this->errors);
    }

    protected function applyRule($field, $value, $rule)
    {
        $params = null;

        if (strpos($rule, ':') !== false) {
            list($rule, $params) = explode(':', $rule);
        }
        

        switch ($rule) {
            case 'required':
                $this->validateRequired($field, $value);
                break;

            case 'email':
                $this->validateEmail($field, $value);
                break;

            case 'unique':
                $this->validateUnique($field, $value, $params);
                break;

            case 'min':
                $this->validateMin($field, $value, $params);
                break;

            case 'max':
                $this->validateMax($field, $value, $params);
                break;

            case 'regex':
                $this->validateRegex($field, $value, $params);
                break;

            case 'match':
                $this->validateMatch($field, $value, $params);
                break;

            case 'mimes':
                $this->validateMimes($field, $params);
                break;

            case 'file_max':
                $this->validateFileMax($field, $params);
                break;

            case 'file_min':
                $this->validateFileMin($field, $params);
                break;

            case 'in':
                $this->validateIn($field, $value, $params);
                break;
        }
    }

    public function addError($field, $message)
    {
        $this->errors[$field][] = $message;
    }

    public function errors()
    {
        return $this->errors;
    }

    public function setToResponse()
    {
        if (Application::getInstance()->isConsole()) {
            foreach ($this->errors as $error) {
                Preview::render($error[0]);
            }
            return;
        }

        if (!empty($this->errors)) {
            Request::isJsonResponse()
                ? self::$errorsBag = $this->errors
                : session()->set(Request::getUri(), $this->errors);
        }
    }
}