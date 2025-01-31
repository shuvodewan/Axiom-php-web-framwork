<?php

namespace Core;

use App\views\render\CoreView;
use Exception;
use Facade\Log as logger;
use Facade\Request as req;
use Facade\Response as Resp;
use Facade\Route as Router;
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
    private function bootRoutes(){
        new Route(Request::getInstance());
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
        ->bootRoutes()
        ->bootLogger();
        return $this;
    }

    public function send(){
        try{
            Router::loadRoutes()->dispatch();
        }catch(Exception $e){
            $this->handleException($e);
        }
        return $this;
    }

    private function handleException($e){
        logger::error($e->getMessage(),[
            'trace'=> $e->getTraceAsString()
        ]);

        if(Req::isJsonResponse()){
            $this->handleJsonExceptionResponse($e);
        }else{
            $this->handleHtmlExceptionResponse($e);
        }

    }

    private function handleJsonExceptionResponse($e){
        if(config('app.debug')){
            resp::json(resp::getJsonErrorResponseData($e->getTraceAsString(),'error',$e->getMessage()))->send();       
        }else{
            resp::json(resp::getJsonErrorResponseData(null,'error','Something Went Wrong!'))->send();        
        }
    }

    private function handleHtmlExceptionResponse($e){
        if(config('app.debug')){
            CoreView::init()->render('errors.debug',['message'=>$e->getMessage(),'trace'=>$e->getTraceAsString()]);
        }else{
            CoreView::init()->render('errors.production',['message'=>'Something Went Wrong!']);
        }
        
    }

    
}