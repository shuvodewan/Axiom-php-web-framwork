<?php

namespace Core;

use Exception;

class Route

{
    static $instance;

    private $request;
    public $routes=[
        'get'=>[],
        'post'=>[],
        'put'=>[],
        'delete'=>[],
        'patch'=>[],
    ];

    public function __construct($request)
    {
        $this->request = $request;
        self::setInstance($this);
    }


    static function setInstance($instance){
        self::$instance = $instance;
    }

    static function getInstance(){
        return self::$instance;
    }

   public function loadRoutes(){
        $files = $this->loadRouteFiles();
        foreach($files as $file){
            $key = pathinfo($file, PATHINFO_FILENAME);
            include route_path('/'.$file);
        }
   }

    private function loadRouteFiles(){
        $files = scandir(route_path());
        return array_diff($files, array('.', '..'));
    }

    private function getMethodName(){
        return debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3)[2]['function'];
    }

    private function registerRoutes($uri, $controller, $method, $middleware=[]){
        $method = $this->getMethodName();
        if(in_array($uri,$this->routes[$method])){
            throw new Exception($uri.' Route already defined');
        }
        array_push($this->routes[$method],$uri);
    }

    public function get($uri, $controller, $method, $middleware=[]){
       $this->registerRoutes($uri, $controller, $method, $middleware=[]);
    }
    public function post($uri, $controller, $method, $middleware=[]){
        $this->registerRoutes($uri, $controller, $method, $middleware=[]);
    }

    public function put($uri, $controller, $method, $middleware=[]){
        $this->registerRoutes($uri, $controller, $method, $middleware=[]);
    }

    public function delete($uri, $controller, $method, $middleware=[]){
        $this->registerRoutes($uri, $controller, $method, $middleware=[]);
    }

    public function patch($uri, $controller, $method, $middleware=[]){
        $this->registerRoutes($uri, $controller, $method, $middleware=[]);
    }

}