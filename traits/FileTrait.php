<?php

namespace Traits;

use Core\Upload;

trait FileTrait
{
    protected $files=[];

    protected function setFiles(){
        foreach ($_FILES as $column => $file) {
            if (is_array($file['name'])) {
                foreach ($file['name'] as $index => $name) {
                    if (!empty($name)) {
                        $this->files[$column][] = new Upload($file);
                    }
                }
            } else {
                if (!empty($file['name'])) {
                    $this->files[$column] = new Upload($file);
                }
            }
        }
    }

    public function getFiles(){
        return $this->files;
    }

    public function files($name){
        return isset($this->files[$name])?$this->files[$name]:null;
    }

    public function file($name){
        if($files =  isset($this->files[$name])?$this->files[$name]:null){
            return is_array($files)?$files[0]:$files;
        };
    }
}
