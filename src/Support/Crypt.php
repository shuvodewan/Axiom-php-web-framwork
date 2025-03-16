<?php

namespace Axiom\Support;

use Exception;

/**
 * Encryption utility class.
 *
 * This class provides a unified interface for encrypting and decrypting data
 * using multiple drivers (e.g., OpenSSL, Sodium) and ciphers (e.g., AES-256-CBC, ChaCha20).
 */
class Crypt
{
    /** @var string The default encryption cipher. */
    private string $cipher = 'aes-256-cbc';

    /** @var string The encryption key. */
    private string $key;

    /** @var array List of supported encryption drivers. */
    private array $supportedDrivers = ['openssl', 'sodium'];

    /** @var int The length of the initialization vector (IV). */
    private int $ivLength;

    /** @var string The encryption driver to use (e.g., 'openssl', 'sodium'). */
    private string $driver = 'openssl';

    /**
     * Constructor.
     *
     * Initializes the encryption utility with the app key and optional driver.
     *
     * @throws Exception If the app key is missing or invalid.
     */
    public function __construct()
    {
        $this->key = $this->getKey();
        $this->ivLength = openssl_cipher_iv_length($this->cipher);
    }

    /**
     * Retrieves the encryption key from the configuration.
     *
     * @return string The encryption key.
     * @throws Exception If the app key is missing.
     */
    private function getKey(): string
    {
        if (!config('app.key')) {
            throw new Exception('App key is missing in configuration.');
        }

        return config('app.key');
    }

    /**
     * Sets the encryption driver.
     *
     * @param string $driver The driver to use (e.g., 'openssl', 'sodium').
     * @return self
     * @throws Exception If the driver is not supported.
     */
    public function setDriver(string $driver): self
    {
        if (!in_array($driver, $this->supportedDrivers)) {
            throw new Exception("Unsupported encryption driver: {$driver}");
        }

        $this->driver = $driver;
        return $this;
    }

    /**
     * Sets the encryption cipher.
     *
     * @param string $cipher The cipher to use (e.g., 'aes-256-cbc', 'chacha20').
     * @return self
     * @throws Exception If the cipher is not supported.
     */
    public function setCipher(string $cipher): self
    {
        $supportedCiphers = ['aes-256-cbc', 'chacha20'];
        if (!in_array($cipher, $supportedCiphers)) {
            throw new Exception("Unsupported encryption cipher: {$cipher}");
        }

        $this->cipher = $cipher;
        $this->ivLength = openssl_cipher_iv_length($this->cipher);
        return $this;
    }

    /**
     * Encrypts data using the configured driver and cipher.
     *
     * @param string $data The data to encrypt.
     * @return string The encrypted data.
     * @throws Exception If encryption fails.
     */
    public function encrypt(string $data): string
    {
        if ($this->driver === 'openssl') {
            return $this->encryptWithOpenSSL($data);
        } elseif ($this->driver === 'sodium') {
            return $this->encryptWithSodium($data);
        }

        throw new Exception("Encryption driver '{$this->driver}' is not implemented.");
    }

    /**
     * Decrypts data using the configured driver and cipher.
     *
     * @param string $data The encrypted data.
     * @return string The decrypted data.
     * @throws Exception If decryption fails.
     */
    public function decrypt(string $data): string
    {
        if ($this->driver === 'openssl') {
            return $this->decryptWithOpenSSL($data);
        } elseif ($this->driver === 'sodium') {
            return $this->decryptWithSodium($data);
        }

        throw new Exception("Decryption driver '{$this->driver}' is not implemented.");
    }

    /**
     * Encrypts data using OpenSSL.
     *
     * @param string $data The data to encrypt.
     * @return string The encrypted data.
     * @throws Exception If encryption fails.
     */
    private function encryptWithOpenSSL(string $data): string
    {
        $iv = openssl_random_pseudo_bytes($this->ivLength);
        $encryptedData = openssl_encrypt($data, $this->cipher, $this->key, 0, $iv);

        if ($encryptedData === false) {
            throw new Exception('OpenSSL encryption failed.');
        }

        return base64_encode($iv . $encryptedData);
    }

    /**
     * Decrypts data using OpenSSL.
     *
     * @param string $data The encrypted data.
     * @return string The decrypted data.
     * @throws Exception If decryption fails.
     */
    private function decryptWithOpenSSL(string $data): string
    {
        $data = base64_decode($data);
        $iv = substr($data, 0, $this->ivLength);
        $encryptedData = substr($data, $this->ivLength);

        $decryptedData = openssl_decrypt($encryptedData, $this->cipher, $this->key, 0, $iv);

        if ($decryptedData === false) {
            throw new Exception('OpenSSL decryption failed.');
        }

        return $decryptedData;
    }

    /**
     * Encrypts data using Sodium.
     *
     * @param string $data The data to encrypt.
     * @return string The encrypted data.
     * @throws Exception If encryption fails.
     */
    private function encryptWithSodium(string $data): string
    {
        if (!function_exists('sodium_crypto_secretbox')) {
            throw new Exception('Sodium extension is not available.');
        }

        $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $encryptedData = sodium_crypto_secretbox($data, $nonce, $this->key);

        return base64_encode($nonce . $encryptedData);
    }

    /**
     * Decrypts data using Sodium.
     *
     * @param string $data The encrypted data.
     * @return string The decrypted data.
     * @throws Exception If decryption fails.
     */
    private function decryptWithSodium(string $data): string
    {
        if (!function_exists('sodium_crypto_secretbox')) {
            throw new Exception('Sodium extension is not available.');
        }

        $data = base64_decode($data);
        $nonce = substr($data, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $encryptedData = substr($data, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);

        $decryptedData = sodium_crypto_secretbox_open($encryptedData, $nonce, $this->key);

        if ($decryptedData === false) {
            throw new Exception('Sodium decryption failed.');
        }

        return $decryptedData;
    }
}