<?php

namespace Core;

use Core\facade\Request;

class Validator
{
    static $errorsBag=[];
    protected $data;
    protected $files;
    protected $rules;
    protected $errors = [];

    public function __construct($request, $rules)
    {
        $this->data = $request->body;
        $this->files = $request->getFiles();
        $this->rules = $rules;
    }

    public function validate()
    {
        foreach ($this->rules as $field => $rules) {
            $value = $this->data[$field] ?? null;

            foreach (explode('|', $rules) as $rule) {
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
                if (empty($value) && !isset($this->files[$field])) {
                    $this->addError($field, "$field is required.");
                }
                break;

            case 'email':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($field, "$field must be a valid email.");
                }
                break;

            case 'unique':
                if ($value && (new Database())->isUnique($params,$field,$value)) {
                    $this->addError($field, "$field exist.");
                }
                break;    

            case 'min':
                if (strlen($value) < $params) {
                    $this->addError($field, "$field must be at least $params characters.");
                }
                break;

            case 'max':
                if (strlen($value) > $params) {
                    $this->addError($field, "$field may not be greater than $params characters.");
                }
                break;

            case 'regex':
                if (!preg_match($params, $value)) {
                    $this->addError($field, "$field has an invalid format.");
                }
                break;

            case 'match':
                if(!isset($this->data[$params])){
                    $this->addError($field, "$params is required.");
                    break;
                }

                if ($value !== $this->data[$params]) {
                    $this->addError($field, "$field must match with $params.");
                }
                break;

            case 'mimes':
                $types = explode(',', $params);

                if(!isset($this->files[$field])){
                    $this->addError($field, "$field must be a file of type: " . implode(', ', $types) . ".");
                }

                $fileType =explode('/', $this->files[$field]->type)[1];
                if (!in_array($fileType, array_map('trim', $types))) {
                    $this->addError($field, "$field must be a file of type: " . implode(', ', $types) . ".");
                }
                break;

            case 'file_max':

                if(!isset($this->files[$field])){
                    $this->addError($field, "$field must be a file of");
                }

                $max = (int) $params * 1024;
                if ($this->files[$field]->size > $max) {
                    $this->addError($field, "$field must not be larger than $params KB.");
                }
                break;

            case 'file_min':

                if(!isset($this->files[$field])){
                    $this->addError($field, "$field must be a file of");
                }

                $minSize = (int) $params * 1024; 
                if ($this->files[$field]->size < $minSize) {
                    $this->addError($field, "$field must be at least $value KB.");
                }
                break;     
        }
    }

    protected function addError($field, $message)
    {
        $this->errors[$field][] = $message;
    }

    public function errors()
    {
        return $this->errors;
    }

    public function setToResponse(){
        if(!empty($this->errors)){
            Request::isJsonResponse()
            ?self::$errorsBag = $this->errors
            :session()->set(Request::getUri(),$this->errors);
        }
    }
}