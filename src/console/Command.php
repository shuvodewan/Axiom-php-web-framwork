<?php

namespace Core\console;

use Core\http\Validator;
use Exception;

abstract class Command
{
    protected $arguments = [];
    protected $options=[];

    abstract public function handle();

    abstract protected function validator():array;

    protected function parseArguments(array $args)
    {
        $data = [];

        foreach ($args as $arg) {
            if (preg_match('/^(?:--([\w-]+)(?:=(.*))?|[\w\d]+)$/', $arg, $matches)) {
                if (!empty($matches[1])) {
                    $option = $matches[1];
                    $value = isset($matches[2]) ? $matches[2] : true;
                    $data[$option] = $value;
                } else {
                    $data[$arg] = true;
                }
            }
        }
        return $data;
    }

    public function setArguments(array $args){
        $data = $this->parseArguments($args);
        $validator = new Validator($data,$this->validator());

        if(!$validator->validate()){
            $validator->setToResponse();
            throw new Exception('Failed to execute command!');
        }
        
        $this->arguments = $data;

        return $this;
    }

    public function empty()
    {
        Preview::render('');
    }

    public function start($message)
    {
        Preview::render('[START] ' . $message);
    }

    public function end($message)
    {
        Preview::render('[END] ' . $message);
    }

    public function title($message)
    {
        Preview::render('[TITLE] ' . $message);
    }

    public function info($message)
    {
        Preview::render('[INFO] ' . $message);
    }

    public function error($message)
    {
        Preview::render('[ERROR] ' . $message,'bright_red');
    }

    public function argument($name)
    {
        return $this->arguments[$name] ?? null;
    }
}