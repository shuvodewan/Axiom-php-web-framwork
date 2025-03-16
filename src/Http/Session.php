<?php

namespace Axiom\Http;

use Axiom\Support\Crypt;
use Axiom\Traits\InstanceTrait;

/**
 * Session management class.
 *
 * This class provides a unified interface for managing PHP sessions, including
 * encryption, cookie configuration, and session data manipulation.
 */
class Session
{
    use InstanceTrait;

    /** @var int The session lifetime in seconds. */
    private int $lifetime;

    /** @var bool Whether the session should expire when the browser closes. */
    private bool $expireOnClose;

    /** @var bool Whether session data should be encrypted. */
    private bool $encrypt;

    /** @var string The name of the session cookie. */
    private string $cookieName;

    /** @var string The path on the server where the session cookie is available. */
    private string $path;

    /** @var string|null The domain where the session cookie is available. */
    private ?string $domain;

    /** @var bool|null Whether the session cookie should only be sent over secure connections. */
    private ?bool $secure;

    /** @var bool Whether the session cookie is accessible only through the HTTP protocol. */
    private bool $httpOnly;

    /** @var string|null The SameSite attribute for the session cookie. */
    private ?string $sameSite;

    /**
     * Constructor.
     *
     * Initializes the session configuration using values from the application configuration.
     */
    public function __construct()
    {
        $this->lifetime = config('session.lifetime', 43200);
        $this->expireOnClose = config('session.expire_on_close', true);
        $this->encrypt = config('session.encrypt', false);
        $this->cookieName = config('session.cookie', 'app_session');
        $this->path = config('session.path', '/');
        $this->domain = config('session.domain', null);
        $this->secure = config('session.secure', null);
        $this->httpOnly = config('session.http_only', true);
        $this->sameSite = config('session.same_site', null);
    }

    /**
     * Encrypts all session data.
     */
    private function encryptAllData(): void
    {
        foreach ($_SESSION as $key => $value) {
            $_SESSION[$key] = (new Crypt())->encrypt($value);
        }
    }

    /**
     * Starts the session with the configured settings.
     */
    public function startSession(): void
    {
        session_set_cookie_params($this->lifetime, $this->path, $this->domain, $this->secure, $this->httpOnly);
        session_name($this->cookieName);

        if ($this->encrypt) {
            $this->encryptAllData();
        }

        if ($this->expireOnClose) {
            session_set_cookie_params(0);
        }

        if ($this->sameSite) {
            ini_set('session.cookie_samesite', $this->sameSite);
        }

        session_start();
    }

    /**
     * Sets a value in the session.
     *
     * @param string $key The session key.
     * @param mixed $value The value to store.
     */
    public function set(string $key, mixed $value): void
    {
        if ($this->encrypt) {
            $value = (new Crypt())->encrypt($value);
        }

        $_SESSION[$key] = $value;
    }

    /**
     * Checks if a session key exists.
     *
     * @param string $key The session key.
     * @return bool True if the key exists, false otherwise.
     */
    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Retrieves and removes a value from the session.
     *
     * @param string $key The session key.
     * @return mixed The value associated with the key, or null if the key does not exist.
     */
    public function pull(string $key): mixed
    {
        $value = $this->get($key);
        unset($_SESSION[$key]);
        return $value;
    }

    /**
     * Retrieves a value from the session.
     *
     * @param string $key The session key.
     * @return mixed The value associated with the key, or null if the key does not exist.
     */
    public function get(string $key): mixed
    {
        if (empty($_SESSION[$key])) {
            return null;
        }

        $value = $_SESSION[$key];

        if ($this->encrypt) {
            return (new Crypt())->decrypt($value);
        }

        return $value;
    }

    /**
     * Destroys the session and clears all session data.
     */
    public function destroy(): void
    {
        session_unset();
        session_destroy();
    }

    /**
     * Regenerates the session ID.
     *
     * @param bool $deleteOldSession Whether to delete the old session data.
     */
    public function regenerateId(bool $deleteOldSession = true): void
    {
        session_regenerate_id($deleteOldSession);
    }
}