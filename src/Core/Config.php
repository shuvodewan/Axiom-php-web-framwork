<?php

namespace Axiom\Core;

use Axiom\Traits\InstanceTrait;

/**
 * Configuration management class.
 *
 * This class loads configuration files from the config directory and provides
 * methods to retrieve and set configuration values using dot notation.
 */
class Config
{
    use InstanceTrait;

    /** @var array The loaded configuration settings. */
    private array $configs = [];

    /**
     * Constructor.
     *
     * Initializes the configuration by loading configuration files.
     */
    public function __construct()
    {
        $this->initiateConfigs();
        self::$instance = $this;
    }

    /**
     * Loads configuration files from the config directory.
     */
    private function initiateConfigs(): void
    {
        $files = $this->loadConfigsFromFile();
        foreach ($files as $file) {
            $key = pathinfo($file, PATHINFO_FILENAME);
            $config = include config_path('/' . $file);
            $this->configs[$key] = $config;
        }
    }

    /**
     * Scans the config directory for configuration files.
     *
     * @return array The list of configuration files.
     */
    private function loadConfigsFromFile(): array
    {
        $files = scandir(config_path());
        return array_diff($files, ['.', '..']);
    }

    /**
     * Retrieves a value from a configuration array or object.
     *
     * @param array|object $configs The configuration array or object.
     * @param string $key The key to retrieve.
     * @return mixed The configuration value, or null if not found.
     */
    private function getValue($configs, string $key)
    {
        if (is_array($configs) && isset($configs[$key])) {
            return $configs[$key];
        } elseif (is_object($configs) && isset($configs->$key)) {
            return $configs->$key;
        } else {
            return null;
        }
    }

    /**
     * Parses a configuration key using dot notation.
     *
     * @param string $key The configuration key in dot notation (e.g., 'app.name').
     * @return mixed The configuration value, or null if not found.
     */
    private function parseConfig(string $key)
    {
        $keys = explode('.', $key);
        $configs = $this->configs;

        foreach ($keys as $key) {
            if (!$data = $this->getValue($configs, $key)) {
                return $data;
            }
            $configs = $data;
        }

        return $configs;
    }

    /**
     * Retrieves a configuration value.
     *
     * @param string $key The configuration key in dot notation (e.g., 'app.name').
     * @param mixed $default The default value to return if the key is not found.
     * @return mixed The configuration value, or the default value if not found.
     */
    public function get(string $key, $default = null)
    {
        return $this->parseConfig($key) ?? $default;
    }

    /**
     * Sets a configuration value.
     *
     * @param string $key The configuration key in dot notation (e.g., 'app.name').
     * @param mixed $value The value to set.
     */
    public function set(string $key, $value): void
    {
        $keys = explode('.', $key);
        $configs = &$this->configs;

        foreach ($keys as $key) {
            if (is_array($configs)) {
                if (!isset($configs[$key]) || (!is_array($configs[$key]) && !is_object($configs[$key]))) {
                    $configs[$key] = [];
                }
                $configs = &$configs[$key];
            } elseif (is_object($configs)) {
                if (!isset($configs->$key) || (!is_array($configs->$key) && !is_object($configs->$key))) {
                    $configs->$key = [];
                }
                $configs = &$configs->$key;
            } else {
                $configs = [];
                $configs[$key] = [];
                $configs = &$configs[$key];
            }
        }

        $configs = $value;
    }
}