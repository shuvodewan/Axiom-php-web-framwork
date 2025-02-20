<?php

namespace Core\console;

abstract class Command
{
    protected $arguments = [];
    protected $signature='';

    abstract public function handle();

    public function parseArguments(array $args)
    {
        $parsedArgs = [];
        $parsedOptions = [];

        $optionPattern = '/^--([\w-]+)(?:=(.*))?$/'; 
        $shortOptionPattern = '/^-(\w)$/'; 

        foreach ($args as $arg) {

            if (preg_match($optionPattern, $arg, $matches)) {
                $optionName = $matches[1];
                $optionValue = $matches[2] ?? true;
                $parsedOptions[$optionName] = $optionValue;
            }

            elseif (preg_match($shortOptionPattern, $arg, $matches)) {
                $parsedOptions[$matches[1]] = true; 
            }

            else {
                $parsedArgs[] = $arg;
            }
        }

        return [$parsedArgs, $parsedOptions];
    }

    public function info($message)
    {
        echo "[INFO] $message\n";
    }

    public function error($message)
    {
        echo "[ERROR] $message\n";
    }

    public function argument($name)
    {
        return $this->arguments[$name] ?? null;
    }

    public function option($name)
    {
        return $this->options[$name] ?? null;
    }
}