<?php

namespace Core;

use Exception;
use Facade\Log as logger;
use Facade\Response as Resp;
use Traits\EnvironmentTrait;

class Application
{

    use EnvironmentTrait;

    static $instance;

    public function __construct()
    {
        self::setInstance($this);
        return $this;
    }

    static function setInstance($instance){
        self::$instance = $instance;
    }

    static function getInstance(){
        return self::$instance;
    }
    private function bootRequest(){
        Request::setInstance()->capture();
        return $this;
    }

    private function bootResponse(){
        new Response();
        return $this;
    }

    private function bootLogger(){
        new Log();
        return $this;
    }
    private function loadRoutes(){
        (new Route())
        ->loadRoutes();
        return $this;
    }

    public function bootConfig(){
        new Config();
        return $this;
    }

    public function boot(){
        $this->loadEnv()
        ->bootConfig()
        ->bootRequest()
        ->bootResponse()
        ->bootLogger();
        return $this;
    }

    public function send(){
        try{
            $this->loadRoutes();
        }catch(Exception $e){
            $this->handleException($e);
        }
        return $this;
    }

    private function handleException($e){
        logger::error($e->getMessage(),[
            'trace'=> $e->getTraceAsString()
        ]);

        if(config('app.debug')){
            Resp::view('errors.debug',['message'=>$e->getMessage(),'trace'=>$e->getTraceAsString()])->send();
        }
    }

    
}