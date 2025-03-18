<?php

namespace Axiom\Facade;

use Axiom\Http\Request as HttpRequest;

/**
 * Request Facade
 *
 * Provides a static interface to the `HttpRequest` class for handling HTTP requests.
 * This facade allows convenient access to request-related methods without needing to
 * manually instantiate the `HttpRequest` class.
 */
class Request implements FacadeContract
{
    use FacadeTrait;

    /**
     * Get the underlying instance of the `HttpRequest` class.
     *
     * @return HttpRequest The singleton instance of `HttpRequest`
     */
    public static function getInstance(): HttpRequest
    {
        return HttpRequest::getInstance();
    }
}