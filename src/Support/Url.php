<?php

namespace Axiom\Support;

/**
 * Comprehensive URL generator and manipulator
 * 
 * Handles all URL-related operations including generation, modification,
 * and inspection of URLs within the application.
 */
class Url
{
    /**
     * Custom base URL override
     * @var string|null
     */
    protected $baseUrl = null;

    /**
     * Forced root URL (highest priority override)
     * @var string|null
     */
    protected $forcedRoot = null;

    /**
     * Custom URL formatters
     * @var array
     */
    protected $formatters = [];

    /**
     * Custom asset root URL
     * @var string|null
     */
    protected $assetRoot = null;

    /**
     * Default parameters for all URLs
     * @var array
     */
    protected $defaultParameters = [];

    /**
     * APP_URL from environment
     * @var string|null
     */
    protected $appUrl;

    /**
     * Constructor - initializes with APP_URL from environment
     * 
     * Example:
     * $url = new Url(); // Automatically uses APP_URL from .env
     */
    public function __construct()
    {
        $this->appUrl = env('app.APP_URL');
    }

    /**
     * Set custom base URL (overrides environment)
     * 
     * Example:
     * $url->setBaseUrl('https://api.example.com');
     * 
     * @param string $url The base URL to set
     * @return self
     */
    public function setBaseUrl(string $url): self
    {
        $this->baseUrl = rtrim($url, '/');
        return $this;
    }

    /**
     * Set custom asset root URL
     * 
     * Example:
     * $url->setAssetRoot('https://cdn.example.com');
     * 
     * @param string $url The asset root URL
     * @return self
     */
    public function setAssetRoot(string $url): self
    {
        $this->assetRoot = rtrim($url, '/');
        return $this;
    }

    /**
     * Force a specific root URL (overrides all other settings)
     * 
     * Example:
     * $url->forceRootUrl('https://admin.example.com');
     * 
     * @param string $root The root URL to force
     * @return self
     */
    public function forceRootUrl(string $root): self
    {
        $this->forcedRoot = rtrim($root, '/');
        return $this;
    }

    /**
     * Set default parameters for all generated URLs
     * 
     * Example:
     * $url->setDefaultParameters(['locale' => 'en']);
     * $url->to('contact'); // Includes ?locale=en
     * 
     * @param array $parameters Default parameters
     * @return self
     */
    public function setDefaultParameters(array $parameters): self
    {
        $this->defaultParameters = $parameters;
        return $this;
    }

    /**
     * Get the base URL (scheme + host)
     * 
     * Example:
     * echo $url->base(); // https://example.com
     * 
     * @return string
     */
    public function base(): string
    {
        if ($this->forcedRoot) {
            return $this->forcedRoot;
        }

        if ($this->baseUrl) {
            return $this->baseUrl;
        }

        return $this->detectBaseUrl();
    }

    /**
     * Detect the base URL from environment or server
     * 
     * @return string
     */
    protected function detectBaseUrl(): string
    {
        if ($this->appUrl) {
            return rtrim($this->appUrl, '/');
        }
        $scheme = $this->getScheme();
        $host = $this->getHost();
        $port = $this->getPort();
        return $scheme . '://' . $host . ($port && !in_array($port, [80, 443]) ? ":{$port}" : '');
    }

    /**
     * Get the current scheme (http/https)
     * 
     * @return string
     */
    protected function getScheme(): string
    {
        if ($this->appUrl) {
            return parse_url($this->appUrl, PHP_URL_SCHEME) ?? 'http';
        }

        if (!empty($_SERVER['HTTPS'])) {
            return $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        }

        if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
            return strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']);
        }

        if (!empty($_SERVER['REQUEST_SCHEME'])) {
            return $_SERVER['REQUEST_SCHEME'];
        }

        return (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) ? 'https' : 'http';
    }

    /**
     * Get the host name
     * 
     * @return string
     */
    protected function getHost(): string
    {
        if ($this->appUrl) {
            $host = parse_url($this->appUrl, PHP_URL_HOST);
            if ($host) {
                return $host;
            }
        }
        return $_SERVER['SERVER_NAME']?? 'localhost';
    }

    /**
     * Get the port number
     * 
     * @return int|null
     */
    protected function getPort(): ?int
    {
        if ($this->appUrl) {
            $port = parse_url($this->appUrl, PHP_URL_PORT);
            if ($port) {
                return $port;
            }
        }

        return isset($_SERVER['SERVER_PORT']) ? (int)$_SERVER['SERVER_PORT'] : null;
    }

    /**
     * Generate a complete URL
     * 
     * Examples:
     * $url->to('products'); // https://example.com/products
     * $url->to('products', ['sort' => 'price']); // With query params
     * $url->to(null, ['page' => 2]); // Just query params
     * 
     * @param string|null $path The URL path
     * @param array $parameters Query parameters
     * @param bool|null $secure Force HTTPS
     * @return string
     */
    public function to(?string $path = null, array $parameters = [], ?bool $secure = null): string
    {
        $url = $this->base();
        $parameters = array_merge($this->defaultParameters, $parameters);

        if ($path) {
            $url .= '/' . ltrim($path, '/');
        }

        if (!empty($parameters)) {
            $url .= '?' . http_build_query($parameters);
        }

        if ($secure !== null) {
            $url = $this->forceScheme($url, $secure ? 'https' : 'http');
        }

        return $url;
    }

    /**
     * Generate a secure (HTTPS) URL
     * 
     * Example:
     * $url->secure('checkout'); // https://example.com/checkout
     * 
     * @param string|null $path The URL path
     * @param array $parameters Query parameters
     * @return string
     */
    public function secure(?string $path = null, array $parameters = []): string
    {
        return $this->to($path, $parameters, true);
    }

    /**
     * Generate URL to an asset
     * 
     * Examples:
     * $url->asset('css/app.css'); // https://example.com/assets/css/app.css
     * $url->asset('img/logo.png', true); // Force HTTPS
     * 
     * @param string $path Asset path
     * @param bool|null $secure Force HTTPS
     * @return string
     */
    public function asset(string $path, ?bool $secure = null): string
    {
        $root = $this->assetRoot ?: $this->base();
        $path = ltrim($path, '/');

        if (str_contains($root, '://')) {
            return $this->forceScheme("{$root}/{$path}", $secure ? 'https' : null);
        }

        return $this->to("assets/{$path}", [], $secure);
    }

    /**
     * Generate secure URL to an asset
     * 
     * Example:
     * $url->secureAsset('js/app.js'); // https://example.com/assets/js/app.js
     * 
     * @param string $path Asset path
     * @return string
     */
    public function secureAsset(string $path): string
    {
        return $this->asset($path, true);
    }

    /**
     * Get current URL
     * 
     * Examples:
     * $url->current(); // https://example.com/products?page=2
     * $url->current(false); // https://example.com/products (without query)
     * 
     * @param bool $withQueryString Include query string
     * @return string
     */
    public function current(bool $withQueryString = true): string
    {
        $url = $this->base() . ($_SERVER['REQUEST_URI'] ?? '/');

        if (!$withQueryString) {
            $url = strtok($url, '?');
        }

        return $url;
    }

    /**
     * Get previous URL (from Referer header)
     * 
     * Example:
     * $url->previous('/home'); // Returns Referer or falls back to /home
     * 
     * @param string $fallback Fallback URL if no Referer
     * @return string
     */
    public function previous(string $fallback = '/'): string
    {
        return $_SERVER['HTTP_REFERER'] ?? $this->to($fallback);
    }

    /**
     * Force scheme (http/https) for a URL
     * 
     * Example:
     * $url->forceScheme('http://example.com', 'https'); // https://example.com
     * 
     * @param string $url URL to modify
     * @param string $scheme Scheme to force (http/https)
     * @return string
     */
    public function forceScheme(string $url, string $scheme): string
    {
        return preg_replace('~^(https?://)~i', $scheme . '://', $url);
    }

    /**
     * Register a custom URL formatter
     * 
     * Example:
     * $url->format('api', fn($path) => $this->to("api/v1/$path"));
     * $url->format('api')('users'); // https://example.com/api/v1/users
     * 
     * @param string $name Formatter name
     * @param callable $formatter Formatter function
     * @return self
     */
    public function format(string $name, callable $formatter): self
    {
        $this->formatters[$name] = $formatter;
        return $this;
    }

    /**
     * Generate a signed URL (placeholder implementation)
     * 
     * Example:
     * $url->signed('download', ['file' => 'report.pdf']);
     * 
     * @param string $path URL path
     * @param array $parameters Query parameters
     * @param \DateTimeInterface|null $expiration Expiration time
     * @return string
     */
    public function signed(string $path, array $parameters = [], \DateTimeInterface $expiration = null): string
    {
        $url = $this->to($path, $parameters);
      //TODO
        return $url;
    }

    /**
     * Generate a temporary signed URL (placeholder implementation)
     * 
     * Example:
     * $url->temporarySigned('download', ['file' => 'report.pdf'], now()->addHour());
     * 
     * @param string $path URL path
     * @param array $parameters Query parameters
     * @param \DateTimeInterface $expiration Expiration time
     * @return string
     */
    public function temporarySigned(string $path, array $parameters = [], \DateTimeInterface $expiration): string
    {
        return $this->signed($path, $parameters, $expiration);
    }

    /**
     * Add query parameters to a URL
     * 
     * Example:
     * $url->withQuery('https://example.com?page=1', ['sort' => 'name']);
     * // Returns: https://example.com?page=1&sort=name
     * 
     * @param string $url Original URL
     * @param array $parameters Parameters to add
     * @return string
     */
    public function withQuery(string $url, array $parameters): string
    {
        $parsed = parse_url($url);
        $query = [];

        if (isset($parsed['query'])) {
            parse_str($parsed['query'], $query);
        }

        $query = array_merge($query, $parameters);
        $parsed['query'] = http_build_query($query);

        return $this->buildUrl($parsed);
    }

    /**
     * Replace all query parameters in a URL
     * 
     * Example:
     * $url->withQueryReplace('https://example.com?page=1', ['sort' => 'name']);
     * // Returns: https://example.com?sort=name
     * 
     * @param string $url Original URL
     * @param array $parameters New parameters
     * @return string
     */
    public function withQueryReplace(string $url, array $parameters): string
    {
        $parsed = parse_url($url);
        $parsed['query'] = http_build_query($parameters);
        return $this->buildUrl($parsed);
    }

    /**
     * Build URL from parsed components
     * 
     * @param array $parts Parsed URL components
     * @return string
     */
    protected function buildUrl(array $parts): string
    {
        return (isset($parts['scheme']) ? "{$parts['scheme']}:" : '') .
            ((isset($parts['user']) || isset($parts['host'])) ? '//' : '') .
            (isset($parts['user']) ? "{$parts['user']}" : '') .
            (isset($parts['pass']) ? ":{$parts['pass']}" : '') .
            (isset($parts['user']) ? '@' : '') .
            (isset($parts['host']) ? "{$parts['host']}" : '') .
            (isset($parts['port']) ? ":{$parts['port']}" : '') .
            (isset($parts['path']) ? "{$parts['path']}" : '') .
            (isset($parts['query']) ? "?{$parts['query']}" : '') .
            (isset($parts['fragment']) ? "#{$parts['fragment']}" : '');
    }

    /**
     * Get current path
     * 
     * Example:
     * $url->path(); // Returns '/products' for https://example.com/products
     * 
     * @return string
     */
    public function path(): string
    {
        return parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    }

    /**
     * Check if current path matches given path
     * 
     * Example:
     * if ($url->is('/admin')) { ... }
     * 
     * @param string $path Path to compare
     * @return bool
     */
    public function is(string $path): bool
    {
        return $this->path() === $path;
    }

    /**
     * Check if current URL matches pattern
     * 
     * Example:
     * if ($url->matches('admin/*')) { ... }
     * 
     * @param string $pattern Pattern to match
     * @return bool
     */
    public function matches(string $pattern): bool
    {
        return preg_match('#^' . preg_quote($pattern, '#') . '$#', $this->path());
    }

    /**
     * Create new instance (fluent alternative to constructor)
     * 
     * Example:
     * $url = Url::make();
     * 
     * @return self
     */
    public static function make(): self
    {
        return new self();
    }
}