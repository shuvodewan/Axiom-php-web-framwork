<?php

namespace Core\application;

use Core\http\Request;
use Core\http\Response;
use Core\http\Validator;
use Project\CoreView;

class Controller
{
    protected $request;
    protected $validator;
    protected $response;
    protected $view;


    public function __construct()
    {
        $this->setRequest()
        ->setValidator()
        ->setResponse();
    }

    public function setRequest(){
        $this->request = Request::getInstance();
        return $this;
    }

    public function setValidator(){
        $this->request = new Validator();
        return $this;
    }

    public function setResponse(){
        $this->response = Response::getInstance();
        return $this;
    }

    public function setView(){
        $this->view = CoreView::init();
        return $this;
    }
}