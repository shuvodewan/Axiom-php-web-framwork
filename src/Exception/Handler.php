<?php

namespace Axiom\Exception;

use Throwable;
use ErrorException;
use Axiom\Core\Log;
use Axiom\Http\Request;
use Axiom\Http\Response;
use Axiom\Views\CoreView;

/**
 * Global exception handler for the Axiom framework
 * 
 * Handles error reporting, rendering, and shutdown scenarios
 */
class Handler
{
    /**
     * Exception types that should not be reported
     * 
     * @var array
     */
    protected array $dontReport = [];


    protected $errorTemplatePath = 'errors';

    /**
     * Sensitive server keys to filter from logs and output
     * 
     * @var array
     */
    protected array $sensitiveServerKeys = [
        'DB_PASSWORD',
        'APP_KEY',
        'MAIL_PASSWORD',
        'REDIS_PASSWORD',
        'AWS_SECRET',
        'DATABASE_URL',
        'API_SECRET'
    ];

    /**
     * Register the error and exception handlers
     */
    public function register(): void
    {
        set_exception_handler([$this, 'handleException']);
        set_error_handler([$this, 'handleError']);
        register_shutdown_function([$this, 'handleShutdown']);
    }

    /**
     * Convert PHP errors to ErrorException instances
     * 
     * @param int $level The error level
     * @param string $message The error message
     * @param string $file The filename where the error occurred
     * @param int $line The line number where the error occurred
     * @param array $context The error context
     * @throws ErrorException
     */
    public function handleError(
        int $level,
        string $message,
        string $file = '',
        int $line = 0,
        array $context = []
    ): void {
        if (error_reporting() & $level) {
            throw new ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * Handle uncaught exceptions
     * 
     * @param Throwable $e The uncaught exception
     */
    public function handleException(Throwable $e): void
    {
        $this->report($e);
        $this->render($e);
        exit(1);
    }

    /**
     * Handle PHP shutdown for fatal errors
     */
    public function handleShutdown(): void
    {
        if ($error = error_get_last()) {
            if ($this->isFatalError($error['type'])) {
                $this->handleException(new ErrorException(
                    $error['message'],
                    0,
                    $error['type'],
                    $error['file'],
                    $error['line']
                ));
            }
        }
    }

    /**
     * Determine if the error type is fatal
     * 
     * @param int $type The error type constant
     * @return bool
     */
    protected function isFatalError(int $type): bool
    {
        return in_array($type, [
            E_ERROR,
            E_CORE_ERROR,
            E_COMPILE_ERROR,
            E_PARSE,
            E_USER_ERROR
        ]);
    }

    /**
     * Report or log an exception
     * 
     * @param Throwable $e The exception to log
     */
    protected function report(Throwable $e): void
    {
        if ($this->shouldNotReport($e)) {
            return;
        }

        (new Log())->error($e->getMessage(), [
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
            'trace'   => $this->sanitizeTrace($e->getTraceAsString()),
            'exception' => get_class($e)
        ]);
    }

    /**
     * Sanitize the stack trace by removing sensitive information
     * 
     * @param string $trace The raw stack trace
     * @return string The sanitized stack trace
     */
    protected function sanitizeTrace(string $trace): string
    {
        if (!config('app.debug')) {
            foreach ($this->sensitiveServerKeys as $key) {
                if (isset($_SERVER[$key])) {
                    $trace = str_replace($_SERVER[$key], '*****', $trace);
                }
            }
        }
        return $trace;
    }

    /**
     * Determine if the exception should not be reported
     * 
     * @param Throwable $e The exception to check
     * @return bool
     */
    protected function shouldNotReport(Throwable $e): bool
    {
        foreach ($this->dontReport as $type) {
            if ($e instanceof $type) {
                return true;
            }
        }
        return false;
    }

    /**
     * Render an exception to a response
     * 
     * @param Throwable $e The exception to render
     * @return Response
     */
    public function render(Throwable $e)
    {
        foreach ($this->getCustomHandlers() as $handler) {
            if ($handler->canHandle($e)) {
                return $handler->handle($e);
            }
        }

        return Request::getInstance()->isJsonResponse()
            ? $this->renderJsonResponse($e)
            : $this->renderHttpException($e);
    }

    /**
     * Get the custom exception handlers
     * 
     * @return array
     */
    protected function getCustomHandlers(): array
    {
        return [];
    }

    /**
     * Render a JSON response for the exception
     * 
     * @param Throwable $e The exception to render
     * @return Response
     */
    protected function renderJsonResponse(Throwable $e)
    {
        $status = $this->getStatusCode($e);
        $data = [
            'error' => $e->getMessage(),
            'code'  => $status,
        ];

        if (config('app.debug')) {
            $data['debug'] = [
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
                'trace' => explode("\n", $this->sanitizeTrace($e->getTraceAsString())),
                'type'  => get_class($e)
            ];
        }

        return Response::getInstance()
            ->json($data)
            ->setStatus($status)
            ->send();
    }

    /**
     * Render an HTTP response for the exception
     * 
     * @param Throwable $e The exception to render
     * @return Response
     */
    protected function renderHttpException(Throwable $e)
    {
        return config('app.debug')
            ? (new WhoopsHandler($this->sensitiveServerKeys, $e))->renderWithWhoops()
            : $this->renderProductionError($e);
    }

    /**
     * Render a production-safe error response
     * 
     * @param Throwable $e The exception to render
     * @return Response
     */
    protected function renderProductionError(Throwable $e): void
    {
        $this->renderErrorViewPathFromProject($e);
        $this->renderErrorViewPathFromCore($e);
    }

    /**
     * Get the path to the error view file
     * 
     * @param int $statusCode The HTTP status code
     * @return string The full path to the view file
     */
    private function renderErrorViewPathFromProject(Throwable $e): void
    {
        $statusCode = $this->getStatusCode($e);
        $view = template_path("/{$this->errorTemplatePath}") . "/{$statusCode}.twig";
        if(file_exists($view)){
            (new CoreView())->render($this->errorTemplatePath. '.' . $statusCode,['exception' => $e, 'statusCode' => $statusCode]);
        }
    }

     /**
     * Get the path to the error view file
     * 
     * @param int $statusCode The HTTP status code
     * @return string The full path to the view file
     */
    private function renderErrorViewPathFromCore(Throwable $e): void
    {   
        $statusCode = $this->getStatusCode($e);
        $view = __DIR__ . "/templates/{$statusCode}.php";
        $view = file_exists($view) ? $view : __DIR__ . "/templates/500.php";

        ob_start();
        extract(['exception' => $e, 'statusCode' => $statusCode]);
        include $view;
        
        (new Response())
            ->setContent(ob_get_clean())
            ->setStatus($statusCode)
            ->send();
    }

    /**
     * Get the HTTP status code for the exception
     * 
     * @param Throwable $e The exception to check
     * @return int The HTTP status code
     */
    protected function getStatusCode(Throwable $e): int
    {
        return method_exists($e, 'getStatusCode') 
            ? $e->getStatusCode()
            : ($e instanceof ErrorException ? 500 : 400);
    }
}