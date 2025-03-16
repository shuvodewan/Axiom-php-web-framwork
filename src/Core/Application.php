<?php

namespace Axiom\Core;

use App\views\render\CoreView;
use Axiom\Core\Http\Request;
use Axiom\Core\Http\Response;
use Axiom\Traits\InstanceTrait;
use Exception;
use Core\facade\Log as logger;
use Core\facade\Request as req;
use Core\facade\Response as Resp;
use Core\facade\Router as Rtr;


/**
 * Class Application
 *
 * The main application class that manages the application lifecycle.
 * It handles bootstrapping, environment detection, and exception handling.
 */
class Application
{
    use EnvironmentTrait;
    use InstanceTrait;

    /**
     * The singleton instance of the Application class.
     *
     * @var self|null
     */
    private static ?self $instance = null;

    /**
     * Indicates whether the application is running in a console environment.
     *
     * @var bool
     */
    protected bool $isConsole = false;

    /**
     * Application constructor.
     *
     * Initializes the application and sets the singleton instance.
     */
    public function __construct()
    {
        self::setInstance($this);
        return $this;
    }

    /**
     * Bootstrap the request handling.
     *
     * @return self
     */
    private function bootRequest() :self
    {
        Request::setInstance()->capture();
        return $this;
    }

    /**
     * Bootstrap the response handling
     *
     * @return self
     */
    private function bootResponse() :self
    {
        new Response();
        return $this;
    }

    private function bootLogger(){
        new Log();
        return $this;
    }
    private function bootRoutes(){
        new Router(Request::getInstance());
        return $this;
    }

    private function setConsole(){
        $this->isConsole = true;
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

    public function bootConsole(){
        $this->setConsole()
        ->loadEnv()
        ->bootConfig()
        ->bootLogger();
        return $this;
    }

    public function isConsole(){
        return $this->isConsole;
    }

    public function send(){
        try{
            Rtr::loadRoutes()->dispatch();
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