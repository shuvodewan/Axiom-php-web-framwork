<?php

namespace Core\http;

use Core\facade\Cache;
use Exception;
use Project\middlewares\Register;

class Router

{
    static $instance;

    protected $middlewares=[];
    protected $prefixes=[];
    protected $names=[];
    public $request;
    public $groupParent;
    public $routes=[
        'get'=>[],
        'post'=>[],
        'put'=>[],
        'delete'=>[],
        'patch'=>[],
        'names'=>[]
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
        if(config('app.mode')=='production' && !config('app.route_closure')){
            if($routes = $this->loadFromCache()){
                $this->routes=$routes;
            }else{
              $this->loadFromFile()->setRoutesInCache();  
            }  
        }else{
            $this->loadFromFile();
        }

        return $this;
    }

    private function loadFromCache(){
        return Cache::setFormat('serialize')->setSubDir('service')->get('routes');
    }

    private function setRoutesInCache(){
        return Cache::setFormat('serialize')->setSubDir('service')->set('routes',$this->routes);
    }

    private function loadFromFile(){
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


    public function registerRoutes($method,$route){
        if(isset($route->uri,$this->routes[$method][$route->uri])){
            throw new Exception($route->uri.' Route already defined');
        }

        $params = [
            'controller'=>$route->controller,
            'action'=>$route->action,
            'middleware'=>[...$this->middlewares,...$route->middlewares]
        ];
        $uri = count($this->prefixes)?trim(implode('/',$this->prefixes),'/') . '/' . $route->uri:trim($route->uri,'/');
        $name = count($this->names)?implode('', $this->names) . '' . $route->name:$route->name;
        $this->routes[$method][$uri]=$params;
        $name?$this->routes['names'][$name]=$uri:'';
    }

    public function setGroupData(array $params){
        if(isset($params['middlewares'])){
            $this->setMiddlewares($params['middlewares']);
        }

        if(isset($params['prefix'])){
            $this->setPrefix($params['prefix']);
        }

        if(isset($params['name'])){
            $this->setName($params['name']);
        }
    }


    public function cleanData(){
        $this->middlewares = [];
        $this->prefixes = [];
        $this->names = [];
    }


    public function dispatch() {
        
        foreach ($this->routes[Request::getInstance()->method] as $path => $action) {
            $pattern = preg_replace('/\{([^\/]+)\}/', '([^\/]+)', $path);
            if (preg_match("#^$pattern$#", $this->request->uri=='/'?'':$this->request->uri, $matches)) {
                array_shift($matches);
                return $this->handleAction($action,$matches);
            }
        }
        throw new Exception( $this->request->uri.' route not found',404);
    }


    private function setMiddlewares($middlewares){
        if(!is_array($middlewares)){
            $this->setSingleMiddleware($middlewares);
        }else{
            foreach($middlewares as $middleware){
                $this->setSingleMiddleware($middleware);
            }
        }
    }

    private function setPrefix(string $prefix){
       array_push($this->prefixes,trim($prefix,'/'));
    }

    private function setName(string $name){
        array_push($this->names,$name);
    }


    private function setSingleMiddleware($middleware){
        array_push($this->middlewares,$middleware);
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


    private function handleAction($action,$params=[]){
        $next = array_reduce($this->getRegisterMiddlewares($action['middleware']), function ($next, $middleware) {
            return function ($request) use ($middleware, $next) {
                return (new ($middleware))->handle($request, $next);
            };
        }, function($request) use($action,$params){
            if(is_callable($action['controller'])){
                $this->executeAction($request, $action['controller'],$params);
            }else{
                $this->executeControllerAction($request, $action['controller'], $action['action'],$params);
            }
        });

        return $next($this->request);
    }
    

    private function executeControllerAction($request,$controller,$action=null,$params=[]){
        $action?(new $controller())->$action($request,...$params):(new $controller())();
    }

    private function executeAction($request,$action,$params=[]){
       call_user_func($action,[$request,...$params]);
    }

}