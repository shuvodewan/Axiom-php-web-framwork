<?php

namespace Axiom\Application\Base;

use Axiom\Facade\Request;
use Axiom\Http\Response;
use Axiom\Views\CoreView;

class Controller 
{
    protected $serviceable;
    protected $request;
    protected $message;
    protected $service;
    protected $view = CoreView::class;


    public function __construct()
    {
        $this->request = new Request();

        if($service = $this->serviceable){

            $this->service = new $service();
        }
    }

    protected function view(string $template, array $data){
        (new CoreView())->render($template, $data);
        return $this;
    }


    protected function __get($name) {
        if ($name === 'response') {
            return new Response();
        }
        return null;
    }
}