<?php

namespace Core;

use App\middlewares\Register;
use Exception;

class Route

{
    static $instance;

    protected $middlewares='';
    public $request;
    private $currentRoute;
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
        return self::$instance = $instance;
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
        return $this;
   }

    private function loadRouteFiles(){
        $files = scandir(route_path());
        return array_diff($files, array('.', '..'));
    }

    private function getMethodName(){
        return debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3)[2]['function'];
    }

    private function cleanRouteDependencies(){
        $this->middlewares = '';
    }

    private function registerRoutes($uri, $controller, $action, $middleware=''){
        $method = $this->getMethodName();
        if(isset($uri,$this->routes[$method][$uri])){
            throw new Exception($uri.' Route already defined');
        }

        $route = [
            'controller'=>$controller,
            'action'=>$action,
            'middleware'=>[...$this->middlewares!=''?explode(",", $this->middlewares):[],...$middleware!=''?explode(",", $middleware):[]]
        ];

        $this->routes[$method][$uri]=$route;
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

    public function dispatch() {
        
        foreach ($this->routes[Request::getInstance()->method] as $path => $action) {
            $pattern = preg_replace('/\{([^\/]+)\}/', '([^\/]+)', $path);
            if (preg_match("#^$pattern$#", $this->request->uri, $matches)) {
                array_shift($matches);
                return $this->handleAction($action,$matches);
            }
        }
        throw new Exception( $this->request->uri.' route not found',404);
    }

    private function getRegisterMiddlewares($middlewares){
        $middlewaresStack = [];
        foreach($middlewares as $middleware){
            if($middleware = Register::getMiddleware($middleware)){
                is_array($middleware)?array_push($middlewaresStack,...$middleware):array_push($middlewaresStack,$middleware);
            }
        }
        return array_reverse($middlewaresStack);
    }

    private function executeControllerAction($request,$controller,$action,$params=[]){
        (new $controller())->$action($request,...$params);
    }


    private function handleAction($action,$params=[]){
        $next = array_reduce($this->getRegisterMiddlewares($action['middleware']), function ($next, $middleware) {
            return function ($request) use ($middleware, $next) {
                return (new ($middleware))->handle($request, $next);
            };
        }, function($request) use($action,$params){
            $this->executeControllerAction($request, $action['controller'], $action['action'],$params);
        });

        return $next($this->request);
    }
    

}