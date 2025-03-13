<?php

namespace Core\support;

use Core\http\Response;

abstract class View
{
    abstract protected function composer():array;

    public function render($template,$data=[]){
        Response::getInstance()->view($template,[...$data,...$this->composer()])->send();
    }

    static function init(){
        return new static();
    }
}