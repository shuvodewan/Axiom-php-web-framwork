<?php

namespace Axiom\Core;

use Axiom\Application\AppManager;
use Axiom\Http\Request;
use Axiom\Http\Response;
use Axiom\Http\Router;
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
        try {
            (new Router(Request::getInstance()))->loadRoutes()->dispatch();
        } catch (Exception $e) {
            $this->handleException($e);
        }
        return $this;
    }

    /**
     * Handles exceptions by logging and displaying appropriate error responses.
     *
     * @param Exception $e The exception to handle.
     */
    private function handleException(Exception $e): void
    {
        (new Log())->error($e->getMessage(), [
            'trace' => $e->getTraceAsString(),
        ]);

        if (Request::getInstance()->isJsonResponse()) {
            $this->handleJsonExceptionResponse($e);
        } else {
            $this->handleHtmlExceptionResponse($e);
        }
    }

    /**
     * Handles JSON exception responses.
     *
     * @param Exception $e The exception to handle.
     */
    private function handleJsonExceptionResponse(Exception $e): void
    {
        if (config('app.debug')) {
            Response::getInstance()->json($this->getJsonErrorResponseData($e->getTraceAsString(), 'error', $e->getMessage()))->send();
        } else {
            Response::getInstance()->json($this->getJsonErrorResponseData(null, 'error', 'Something Went Wrong!'))->send();
        }
    }

    /**
     * Handles HTML exception responses.
     *
     * @param Exception $e The exception to handle.
     */
    private function handleHtmlExceptionResponse(Exception $e): void
    {
        if (config('app.debug')) {
            CoreView::init()->render('errors.debug', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        } else {
            CoreView::init()->render('errors.production', ['message' => 'Something Went Wrong!']);
        }
    }

    /**
     * Generates a JSON response data structure.
     *
     * @param mixed|null $data The response data.
     * @param string $status The response status.
     * @param string $message The response message.
     * @return array The JSON response data.
     */
    private function getJsonResponseData($data = null, string $status, string $message): array
    {
        return [
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];
    }

    /**
     * Generates a JSON error response data structure.
     *
     * @param string|null $trace The error trace.
     * @param string $status The response status.
     * @param string $message The response message.
     * @return array The JSON error response data.
     */
    private function getJsonErrorResponseData(?array $trace, string $status, string $message): array
    {
        return [
            'status' => $status,
            'message' => $message,
            'trace' => $trace,
        ];
    }
}