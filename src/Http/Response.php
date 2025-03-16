<?php

namespace Axiom\Http;

use Axiom\Traits\InstanceTrait;

class Response
{
    use InstanceTrait;

    /** @var string The response content. */
    protected string $content = '';

    /** @var int The HTTP status code. */
    protected int $status = 200;

    /** @var array The response headers. */
    protected array $headers = [];

    /** @var array The response cookies. */
    protected array $cookies = [];

    /**
     * Constructor.
     *
     * @param string $viewsPath Path to the views directory.
     * @param string $cachePath Path to the cache directory (optional).
     */
    public function __construct()
    {
        self::setInstance($this);
    }

    /**
     * Sets default headers for the response.
     */
    private function setDefaultHeaders(): void
    {
        header("Cache-Control: no-cache, no-store, must-revalidate");
        header("Pragma: no-cache");
        header("Expires: 0");
    }

    /**
     * Sets the headers for the response.
     */
    private function setHeaders(): void
    {
        $this->setDefaultHeaders();
        foreach ($this->headers as $key => $value) {
            header("{$key}: {$value}");
        }
    }

    /**
     * Sets the cookies for the response.
     */
    private function setCookies(): void
    {
        foreach ($this->cookies as $cookie) {
            setcookie(
                $cookie['name'],
                $cookie['value'],
                config('session.expire_on_close') ? $cookie['expires'] ?? config('session.lifetime') : 0
            );
        }
    }

    /**
     * Sets the response content.
     *
     * @param string $content The content to set.
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * Sets the HTTP status code.
     *
     * @param int $status The status code to set.
     * @return self
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Sends the response.
     */
    public function send(): void
    {
        http_response_code($this->status);

        $this->setHeaders();
        $this->setCookies();

        echo $this->content;

        exit;
    }

    /**
     * Adds a header to the response.
     *
     * @param string $key The header key.
     * @param string $value The header value.
     * @return self
     */
    public function header(string $key, string $value): self
    {
        $this->headers[$key] = $value;
        return $this;
    }

    /**
     * Adds a cookie to the response.
     *
     * @param string $name The cookie name.
     * @param string $value The cookie value.
     * @param int $expires The expiration time in seconds.
     * @return self
     */
    public function cookie(string $name, string $value, int $expires = 0): self
    {
        $this->cookies[] = ['name' => $name, 'value' => $value, 'expires' => $expires];
        return $this;
    }

    /**
     * Sends a JSON response.
     *
     * @param mixed $data The data to encode as JSON.
     * @param int $status The HTTP status code.
     * @return self
     */
    public function json($data, int $status = 200): self
    {
        $this->setStatus($status);
        $this->header('Content-Type', 'application/json');
        $this->content = json_encode($data);
        return $this;
    }

    /**
     * Sends a plain text response.
     *
     * @param string $content The text content.
     * @param int $status The HTTP status code.
     * @return self
     */
    public function text(string $content, int $status = 200): self
    {
        $this->setStatus($status);
        $this->header('Content-Type', 'text/plain');
        $this->content = $content;
        return $this;
    }

    /**
     * Renders a Twig template and sends it as the response.
     *
     * @param string $view The view name.
     * @param array $data The data to pass to the view.
     * @return self
     */
    public function view(string $content): self
    {
        $this->setStatus(200);
        $this->header('Content-Type', 'text/html');
        $this->content = $content;
        return $this;
    }

    /**
     * Sends a file as a download.
     *
     * @param string $filePath The path to the file.
     * @param string|null $filename The name of the file to download.
     * @return self
     */
    public function download(string $filePath, ?string $filename = null): self
    {
        if (!file_exists($filePath)) {
            $this->setStatus(404);
            $this->content = 'File not found.';
            return $this;
        }

        $this->setStatus(200);
        $this->header('Content-Type', 'application/octet-stream');
        $this->header('Content-Disposition', 'attachment; filename="' . ($filename ?? basename($filePath)) . '"');
        $this->content = file_get_contents($filePath);
        return $this;
    }

    /**
     * Redirects to a URL.
     *
     * @param string $url The URL to redirect to.
     * @param int $status The HTTP status code.
     * @return self
     */
    public function redirect(string $url, int $status = 302): self
    {
        $this->setStatus($status);
        $this->header('Location', $url);
        return $this;
    }
}