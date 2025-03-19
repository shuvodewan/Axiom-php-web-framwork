<?php

namespace Axiom\Support;

class Hash
{
    /**
     * Generate a hash for the given value.
     *
     * @param string $value The value to hash.
     * @param int|null $cost The cost factor for the hash algorithm. If null, defaults to the value from config.
     * @return string The hashed value.
     */
    public function make(string $value, ?int $cost = null): string
    {
        // Use the provided cost or fallback to the configured hash cost
        $options = [
            'cost' => $cost ?? config('app.hash_cost')
        ];

        // Generate and return the hash using the BCRYPT algorithm
        return password_hash($value, PASSWORD_BCRYPT, $options);
    }

    /**
     * Verify if the given value matches the hash.
     *
     * @param string $value The value to verify.
     * @param string $hash The hash to compare against.
     * @return bool True if the value matches the hash, false otherwise.
     */
    public function check(string $value, string $hash): bool
    {
        return password_verify($value, $hash);
    }

    /**
     * Check if the given hash needs to be rehashed.
     *
     * @param string $hash The hash to check.
     * @return bool True if the hash needs to be rehashed, false otherwise.
     */
    public function rehash(string $hash): bool
    {
        return password_needs_rehash($hash, PASSWORD_BCRYPT, ['cost' => config('app.hash_cost')]);
    }
}