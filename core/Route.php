<?php

namespace Core;

use Exception;

class Route

{
    protected $router;
    protected $prefix;
    public $name;
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

    public function prefix(string $prefix){
        $this->prefix = trim($prefix,'/'); 
       return $this;
    }

    public function name(string $name){
        $this->name = $name;
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
        $parent = $this->setGroupParent();

        if(is_callable($params)){
            return $params();
        }

        if(is_array($params)){
           $this->router->setGroupData($params);
        }
        
        if(is_callable($func)){
            call_user_func($func);
        }

        $this->cleanGroupData($parent);
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

    private function registerRoutes($uri, $controller, $action=null){
        $this->uri=$this->setUri($uri);
        $this->controller=$controller;
        $this->action=$action;

        $this->router->registerRoutes($this->getMethodName(),$this);
    }


    private function setUri($uri){
       return  $uri =  $this->prefix?$this->prefix . '/' . $uri:$uri;
    }

    private function setGroupParent(){
        if(!$this->router->groupParent){
            $this->router->groupParent = true;
            return true;
        }
    }

    private function cleanGroupData($isParent){
        if($isParent){
            $this->router->cleanData();
        }
    }

}