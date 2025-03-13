<?php

namespace Core\support;

class Config
{
    private $configs= [];
    static $instance;

    public function __construct()
    {
        $this->initiateConfigs();
        self::$instance = $this;
    }

    static function getInstance(){
        return self::$instance;
    }

    public function initiateConfigs(){
        $files = $this->loadConfigsfromFile();
        foreach($files as $file){
            $key = pathinfo($file, PATHINFO_FILENAME);
            $config = include config_path('/'.$file);
            $this->configs[$key] = $config;
        }
    }

    private function loadConfigsfromFile(){
        $files = scandir(config_path());
        return array_diff($files, array('.', '..'));
    }

    private function getValue($configs,$key){
        if (is_array($configs) && isset($configs[$key])) {
            return $configs[$key];
        }elseif(is_object($configs) && $configs->$key){
            return $configs->$key;
        }else {
            return null; 
        }
    }

    private function pharseConfig($key){
        $keys = explode('.', $key); 
        $configs=$this->configs;
        foreach ($keys as $key) {
            if(!$data = $this->getValue($configs,$key)){
                return $data;
            } 
            $configs=$data;    
        }
        return $configs;
    }


    public function get($key,$default=null){
        return $this->pharseConfig($key)??$default;
    }


    public function set($key, $value) {
        $keys = explode('.', $key);
        $configs = &$this->configs;

        foreach ($keys as $key) {
            if (is_array($configs)) {
                if (!isset($configs[$key]) || (!is_array($configs[$key]) && !is_object($configs[$key]))) {
                    $configs[$key] = [];
                }
                $configs = &$configs[$key];
            } elseif (is_object($configs)) {
                if (!isset($configs->$key) || (!is_array($configs->$key) && !is_object($configs->$key))) {
                    $configs->$key = [];
                }
                $configs = &$configs->$key; 
            } else {
                $configs = [];
                $configs[$key] = [];
                $configs = &$configs[$key];
            }
        }

        $configs = $value;
    }
    
}