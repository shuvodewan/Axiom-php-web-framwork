<?php

namespace Axiom\Exception;

use Axiom\Http\Response;
use ErrorException;
use Whoops\Run as Whoops;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Handler\JsonResponseHandler;
use Throwable;

/**
 * Handles exception rendering using Whoops error handler
 * 
 * Provides secure, customizable error pages for development environment
 */
class WhoopsHandler
{
    /**
     * @var array List of sensitive server keys to filter from output
     */
    protected array $sensitiveServerKeys;
    
    /**
     * @var Throwable The exception to handle
     */
    protected Throwable $e;

    /**
     * Constructor
     *
     * @param array $sensitiveServerKeys Keys to filter from output
     * @param Throwable $e Exception to handle
     */
    public function __construct(array $sensitiveServerKeys, Throwable $e)
    {
        $this->sensitiveServerKeys = $sensitiveServerKeys;
        $this->e = $e;
    }

    /**
     * Render exception using Whoops
     *
     * @return Response Prepared HTTP response
     */
    public function renderWithWhoops()
    {
        $whoops = new Whoops();
        $whoops->pushHandler($this->getPageHandler());
        $whoops->allowQuit(false);
        
        ob_start();
        $whoops->handleException($this->e);
        $content = $this->sanitizeWhoopsOutput(ob_get_clean());
        
        return (new Response())
            ->setContent($content)
            ->setStatus($this->getStatusCode())
            ->send();
    }

    /**
     * Sanitize Whoops output by filtering sensitive information
     *
     * @param string $content Raw output content
     * @return string Sanitized content
     */
    protected function sanitizeWhoopsOutput(string $content): string
    {
        foreach ($this->sensitiveServerKeys as $key) {
            if (isset($_SERVER[$key])) {
                $content = str_replace($_SERVER[$key], '*****', $content);
            }
        }
        return $content;
    }

    /**
     * Configure and return PrettyPageHandler
     *
     * @return PrettyPageHandler Configured handler instance
     */
    protected function getPageHandler(): PrettyPageHandler
    {
        $handler = new PrettyPageHandler();
        $handler->setPageTitle("Axiom Framework - Error");
        $handler->setEditor('vscode');
        $this->configureSecureWhoops($handler);
        return $handler;
    }

    /**
     * Secure Whoops handler configuration
     *
     * @param PrettyPageHandler $handler Handler to configure
     */
    protected function configureSecureWhoops(PrettyPageHandler $handler): void
    {
        // Blacklist environment variables
        foreach (array_keys($_ENV) as $key) {
            $handler->blacklist('_ENV', $key);
        }
        
        // Blacklist sensitive server variables
        foreach (array_intersect($this->sensitiveServerKeys, array_keys($_SERVER)) as $key) {
            $handler->blacklist('_SERVER', $key);
        }
        
        $handler->addDataTable('Application', [
            'Version' => config('app.version'),
            'Environment' => config('app.env'),
            'PHP Version' => PHP_VERSION,
        ]);
    }

    /**
     * Determine appropriate HTTP status code for exception
     *
     * @return int HTTP status code
     */
    protected function getStatusCode(): int
    {
        return method_exists($this->e, 'getStatusCode') 
            ? $this->e->getStatusCode()
            : ($this->e instanceof ErrorException ? 500 : 400);
    }
}