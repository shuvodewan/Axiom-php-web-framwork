<?php

namespace Core;

use Exception;

class Route

{
    protected $router;
    protected $prefixes = [];
    public $middlewares = [];
    public $uri;
    public $controller;
    public $action;

    public function __construct()
    {
        $this->router = Router::getInstance();
    }


    public function middlewares($middlewares){
        is_array($middlewares)?$this->setMiddlewares($middlewares):$this->setSingleMiddleware($middlewares);
        return $this;
    }

    public function prefix($prefix){
       array_push($this->prefixes,trim($prefix,'/')); 
       return $this;
    }

    public function loadRoutes(){
            $files = $this->loadRouteFiles();
            foreach($files as $file){
                $key = pathinfo($file, PATHINFO_FILENAME);
                include route_path('/'.$file);
            }
            return $this;
    }

    private function loadRouteFiles(){
        $files = scandir(route_path());
        return array_diff($files, array('.', '..'));
    }

    private function getMethodName(){
        return debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3)[2]['function'];
    }


    public function group($params=[],$func=null){

        if(is_callable($params)){
            return $params();
        }

        if(is_array($params)){
            if(isset($params['middleware'])){
                $this->middlewares = $params['middleware'];
            }
        }
        
        if(is_callable($func)){
            call_user_func($func);
        }

        $this->cleanRouteDependencies();
    }

    public function get($uri, $controller, $action){
       $this->registerRoutes($uri, $controller, $action);
    }
    public function post($uri, $controller, $action){
        $this->registerRoutes($uri, $controller, $action);
    }

    public function put($uri, $controller, $action){
        $this->registerRoutes($uri, $controller, $action);
    }

    public function delete($uri, $controller, $action){
        $this->registerRoutes($uri, $controller, $action);
    }

    public function patch($uri, $controller, $action){
        $this->registerRoutes($uri, $controller, $action);
    }


    private function setSingleMiddleware($middleware){
        !is_array($middleware)?array_push($this->middlewares,$middleware):'';
    }


    private function setMiddlewares($middlewares){
        foreach($middlewares as $middleware){
            $this->setSingleMiddleware($middleware);
        }
    }

    private function registerRoutes($uri, $controller, $action){
        $this->uri=$this->setUri($uri);
        $this->controller=$controller;
        $this->action=$action;

        $this->router->registerRoutes($this->getMethodName(),$this);
    }


    private function setUri($uri){
       return  $uri = count($this->prefixes)?trim(implode('/',$this->prefixes),'/') . '/' . $uri:$uri;
    }

}