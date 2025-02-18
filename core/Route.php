<?php

namespace Core;

use Exception;

class Route

{

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

    private function registerRoutes($uri, $controller, $action, $middleware=''){
        $method = $this->getMethodName();
        if(isset($uri,$this->routes[$method][$uri])){
            throw new Exception($uri.' Route already defined');
        }

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

    public function get($uri, $controller, $action, $middleware=''){
       $this->registerRoutes($uri, $controller, $action, $middleware);
    }
    public function post($uri, $controller, $action, $middleware=''){
        $this->registerRoutes($uri, $controller, $action, $middleware);
    }

    public function put($uri, $controller, $action, $middleware=''){
        $this->registerRoutes($uri, $controller, $action, $middleware);
    }

    public function delete($uri, $controller, $action, $middleware=''){
        $this->registerRoutes($uri, $controller, $action, $middleware);
    }

    public function patch($uri, $controller, $action, $middleware=''){
        $this->registerRoutes($uri, $controller, $action, $middleware);
    }

}