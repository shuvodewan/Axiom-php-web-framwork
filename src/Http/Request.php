<?php

namespace Axiom\Http;

use Axiom\Support\Str;
use Axiom\Traits\InstanceTrait;

class Request
{
    use FileTrait;
    use InstanceTrait;

    /** @var string The URI of the request. */
    public string $uri;

    /** @var string The HTTP method of the request (e.g., GET, POST). */
    public string $method;

    /** @var array The request body parameters (e.g., POST data). */
    public array $body = [];

    /** @var array The query string parameters (e.g., GET data). */
    public array $query = [];

    /** @var string The user agent string. */
    public string $agent;

    /** @var array The request headers. */
    public array $headers = [];

    /** @var string The IP address of the user making the request. */
    public string $userIp;

    /**
     * Captures the request data from the global PHP variables.
     *
     * @return self
     */
    public function capture(): self
    {
        $this->captureBase()
            ->captureQueryStrings()
            ->capturePostBody()
            ->captureFiles()
            ->captureHeaders()
            ->captureUserAgent()
            ->captureUserIp();
        return $this;
    }

    /**
     * Captures the base request data (URI and method).
     *
     * @return self
     */
    private function captureBase(): self
    {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $this->uri = $uri === '' ? '/' : $uri;
        $this->method = (new Str())->toLower($_SERVER['REQUEST_METHOD']);
        return $this;
    }

    /**
     * Captures the query string parameters.
     *
     * @return self
     */
    private function captureQueryStrings(): self
    {
        $this->query = $_GET;
        return $this;
    }

    /**
     * Captures the POST body parameters.
     *
     * @return self
     */
    private function capturePostBody(): self
    {
        $this->body = $_POST;
        return $this;
    }

    /**
     * Captures the uploaded files.
     *
     * @return self
     */
    private function captureFiles(): self
    {
        $this->setFiles();
        return $this;
    }

    /**
     * Captures the request headers.
     *
     * @return self
     */
    private function captureHeaders(): self
    {
        $this->headers = array_map(function ($value) {
            return $value;
        }, array_change_key_case(getallheaders(), CASE_LOWER));

        return $this;
    }

    /**
     * Captures the user agent string.
     *
     * @return self
     */
    private function captureUserAgent(): self
    {
        $this->agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        return $this;
    }

    /**
     * Captures the user's IP address.
     *
     * @return self
     */
    private function captureUserIp(): self
    {
        $this->userIp = $_SERVER['REMOTE_ADDR'] ?? '';
        return $this;
    }

    /**
     * Checks if the response should be JSON.
     *
     * @return bool
     */
    public function isJsonResponse(): bool
    {
        return strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false;
    }

    /**
     * Checks if the response should be XML.
     *
     * @return bool
     */
    public function isXmlResponse(): bool
    {
        return strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/xml') !== false || strpos($_SERVER['CONTENT_TYPE'] ?? '', 'text/xml') !== false;
    }

    /**
     * Checks if the response should be HTML.
     *
     * @return bool
     */
    public function isHtmlResponse(): bool
    {
        return strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'text/html') !== false;
    }

    /**
     * Checks if the response should be form data.
     *
     * @return bool
     */
    public function isFormResponse(): bool
    {
        return strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/x-www-form-urlencoded') !== false;
    }

    /**
     * Checks if the response should be multipart form data.
     *
     * @return bool
     */
    public function isMultipartFormResponse(): bool
    {
        return strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'multipart/form-data') !== false;
    }

    /**
     * Checks if the response should be plain text.
     *
     * @return bool
     */
    public function isPlainTextResponse(): bool
    {
        return strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'text/plain') !== false;
    }

    /**
     * Checks if the response should be JavaScript.
     *
     * @return bool
     */
    public function isJavascriptResponse(): bool
    {
        return strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/javascript') !== false || strpos($_SERVER['CONTENT_TYPE'] ?? '', 'text/javascript') !== false;
    }

    /**
     * Checks if the response should be CSS.
     *
     * @return bool
     */
    public function isCssResponse(): bool
    {
        return strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'text/css') !== false;
    }

    /**
     * Checks if the request is JSON.
     *
     * @return bool
     */
    public function isJsonRequest(): bool
    {
        return strpos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false;
    }

    /**
     * Checks if the request is XML.
     *
     * @return bool
     */
    public function isXmlRequest(): bool
    {
        return strpos($_SERVER['CONTENT_TYPE'] ?? '', 'application/xml') !== false || strpos($_SERVER['CONTENT_TYPE'] ?? '', 'text/xml') !== false;
    }

    /**
     * Checks if the request is HTML.
     *
     * @return bool
     */
    public function isHtmlRequest(): bool
    {
        return strpos($_SERVER['CONTENT_TYPE'] ?? '', 'text/html') !== false;
    }

    /**
     * Checks if the request is form data.
     *
     * @return bool
     */
    public function isFormRequest(): bool
    {
        return strpos($_SERVER['CONTENT_TYPE'] ?? '', 'application/x-www-form-urlencoded') !== false;
    }

    /**
     * Checks if the request is multipart form data.
     *
     * @return bool
     */
    public function isMultipartFormRequest(): bool
    {
        return strpos($_SERVER['CONTENT_TYPE'] ?? '', 'multipart/form-data') !== false;
    }

    /**
     * Checks if the request is plain text.
     *
     * @return bool
     */
    public function isPlainTextRequest(): bool
    {
        return strpos($_SERVER['CONTENT_TYPE'] ?? '', 'text/plain') !== false;
    }

    /**
     * Checks if the request is JavaScript.
     *
     * @return bool
     */
    public function isJavascriptRequest(): bool
    {
        return strpos($_SERVER['CONTENT_TYPE'] ?? '', 'application/javascript') !== false || strpos($_SERVER['CONTENT_TYPE'] ?? '', 'text/javascript') !== false;
    }

    /**
     * Checks if the request is CSS.
     *
     * @return bool
     */
    public function isCssRequest(): bool
    {
        return strpos($_SERVER['CONTENT_TYPE'] ?? '', 'text/css') !== false;
    }

    /**
     * Retrieves a header by its key.
     *
     * @param string $key The header key.
     * @return string|null The header value or null if not found.
     */
    public function getHeader(string $key): ?string
    {
        return $this->headers[$key] ?? null;
    }

    /**
     * Retrieves a body parameter by its key.
     *
     * @param string $key The body parameter key.
     * @return mixed The body parameter value or null if not found.
     */
    public function getBody(string $key): mixed
    {
        return $this->body[$key] ?? null;
    }

    /**
     * Retrieves a query parameter by its key.
     *
     * @param string $key The query parameter key.
     * @return mixed The query parameter value or null if not found.
     */
    public function getQuery(string $key): mixed
    {
        return $this->query[$key] ?? null;
    }

    /**
     * Retrieves the request URI.
     *
     * @return string The request URI.
     */
    public function getUri(): string
    {
        return $this->uri;
    }
}