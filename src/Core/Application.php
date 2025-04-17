<?php

namespace Axiom\Core;

use Axiom\Application\AppManager;
use Axiom\Http\Request;
use Axiom\Http\Response;
use Axiom\Http\Router;
use Axiom\Project\Exceptions\Handler;
use Axiom\Project\Registry;
use Axiom\Traits\InstanceTrait;
use Axiom\Views\CoreView;
use Exception;

/**
 * Application class.
 *
 * This class manages the application lifecycle, including bootstrapping,
 * environment detection, and exception handling.
 */
class Application
{
    use EnvironmentTrait;
    use InstanceTrait;

    /** @var self|null The singleton instance of the Application class. */
    private static ?self $instance = null;

    /** @var bool Indicates whether the application is running in a console environment. */
    protected bool $isConsole = false;

    /**
     * Constructor.
     *
     * Initializes the application and sets the singleton instance.
     */
    public function __construct()
    {
        self::setInstance($this);
    }

    /**
     * Bootstraps the request handling.
     *
     * @return self
     */
    private function bootRequest(): self
    {
        Request::setInstance()->capture();
        return $this;
    }

    /**
     * Bootstraps the response handling.
     *
     * @return self
     */
    private function bootResponse(): self
    {
        new Response();
        return $this;
    }

    /**
     * Bootstraps Project.
     *
     * @return self
     */
    private function bootProject() :self
    {
        Registry::boot();
        return $this;
    }

    /**
     * Bootstraps Project apps.
     *
     * @return self
     */
    private function bootProjectApps() :self
    {
        AppManager::getInstance();
        return $this;
    }

    /**
     * Bootstraps the logger.
     *
     * @return self
     */
    private function bootLogger(): self
    {
        new Log();
        return $this;
    }

    /**
     * Bootstraps the routes.
     *
     * @return self
     */
    private function bootRoutes(): self
    {
        new Router(Request::getInstance());
        return $this;
    }

    /**
     * Sets the application to console mode.
     *
     * @return self
     */
    private function setConsole(): self
    {
        $this->isConsole = true;
        return $this;
    }

    /**
     * Bootstraps the configuration.
     *
     * @return self
     */
    public function bootConfig(): self
    {
        new Config();
        return $this;
    }

     /**
     * Bootstraps the containerfor dependency injection.
     *
     * @return self
     */
    public function bootContainer() :self
    {
        new Container(); 
        
        return $this;
    }

     /**
     * Bootstraps the containerfor dependency injection.
     *
     * @return self
     */
    public function bootExceptionHandler() :self
    {
        (new Handler())->register(); 
        
        return $this;
    }

    /**
     * Bootstraps the application for web requests.
     *
     * @return self
     */
    public function boot(): self
    {
        $this->loadEnv()
            ->bootConfig()
            ->bootRequest()
            ->bootResponse()
            ->bootContainer()
            ->bootExceptionHandler()
            ->bootProject()
            ->bootProjectApps()
            ->bootRoutes()
            ->bootLogger();
        return $this;
    }

    /**
     * Bootstraps the application for console commands.
     *
     * @return self
     */
    public function bootConsole(): self
    {
        $this->setConsole()
            ->loadEnv()
            ->bootConfig()
            ->bootLogger();
        return $this;
    }

    /**
     * Checks if the application is running in console mode.
     *
     * @return bool True if running in console mode, false otherwise.
     */
    public function isConsole(): bool
    {
        return $this->isConsole;
    }

    /**
     * Sends the response by dispatching the request.
     *
     * @return self
     */
    public function send(): self
    {
        (new Router(Request::getInstance()))->loadRoutes()->dispatch();
        return $this;
    }
}