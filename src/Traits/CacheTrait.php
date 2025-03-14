<?php

namespace Core\traits;

use Exception;

trait CacheTrait
{
    private $allowedFormat=['json','serialize'];
    private $format='json';
    private $subdir='data';


    public function setFormat(string $format){
        if(in_array($format,$this->allowedFormat)){
            $this->format=$format;
            return $this;
        }

        throw new Exception('Format not allowed');
    }

    public function setSubDir(string $dir){
        $this->subdir=$dir;
        return $this;
    }

    private function getSerializeData($data){
        return $this->format=='json'?json_encode($data):serialize($data);
    }

    private function getDeserializeData($data){
        return $this->format=='json'?json_decode($data,true):unserialize($data);
    }
}