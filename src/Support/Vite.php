<?php

namespace Axiom\Support;

/**
 * Vite Asset Loader
 * 
 * Handles loading of Vite assets in both development and production environments.
 * Provides static and instance-based methods for generating HTML tags for JavaScript and CSS assets.
 */
class Vite
{
    /**
     * @var array Vite configuration parameters
     */
    private array $config = [];

    /**
     * Constructor
     * 
     * Initializes the Vite instance by loading the configuration.
     * Configuration is typically loaded from the framework's config system.
     */
    public function __construct()
    {
        $this->config = config('vite');
    }

    /**
     * Generate HTML tags for Vite assets (static shortcut)
     * 
     * @param array $entrypoints Array of entry points (e.g., ['resources/js/app.js', 'resources/css/app.css'])
     * @return string Generated HTML tags for the specified entry points
     */
    public static function load(array $entrypoints): string
    {
        return (new static())->loadAssets($entrypoints);
    }

    /**
     * Generate HTML tags for Vite assets (instance method)
     * 
     * @param array $entrypoints Array of entry points to load
     * @return string Generated HTML tags
     */
    public function loadAssets(array $entrypoints): string
    {
        return $this->isDevMode() 
            ? $this->loadFromDevServer($entrypoints)
            : $this->loadFromBuild($entrypoints);
    }

    /**
     * Check if running in development mode
     * 
     * Determines if the application is in development mode by checking for the Vite hot file.
     * 
     * @return bool True if in development mode, false otherwise
     */
    private function isDevMode(): bool
    {
        return file_exists($this->getBuildPath($this->config['hot_file']));
    }

    /**
     * Load assets from Vite development server
     * 
     * Generates HTML tags that point directly to the Vite dev server.
     * 
     * @param array $entrypoints Array of entry points to load
     * @return string HTML tags for development assets
     */
    private function loadFromDevServer(array $entrypoints): string
    {
        $tags = [];
        $devServer = rtrim($this->config['dev_server'], '/');
        
        foreach ($entrypoints as $entry) {
            $url = $devServer . '/' . ltrim($entry, '/');
            
            if ($this->isJsFile($entry)) {
                $tags[] = sprintf('<script type="module" src="%s"></script>', $url);
            } elseif ($this->isCssFile($entry)) {
                $tags[] = sprintf('<link rel="stylesheet" href="%s">', $url);
            }
        }

        return implode('', $tags);
    }

    /**
     * Load assets from production build
     * 
     * Generates HTML tags for production-optimized assets using the manifest file.
     * 
     * @param array $entrypoints Array of entry points to load
     * @return string HTML tags for production assets
     */
    private function loadFromBuild(array $entrypoints): string
    {
        $manifest = $this->readManifest();
        $tags = [];
        $buildDir = '/' . trim($this->config['build_dir'], '/');

        foreach ($entrypoints as $entry) {
            if (!isset($manifest[$entry])) {
                continue;
            }

            $filePath = $buildDir . '/' . $manifest[$entry]['file'];
            
            if ($this->isJsFile($manifest[$entry]['file'])) {
                $tags[] = sprintf('<script type="module" src="%s"></script>', $filePath);
            } elseif ($this->isCssFile($manifest[$entry]['file'])) {
                $tags[] = sprintf('<link rel="stylesheet" href="%s">', $filePath);
            }
        }

        return implode('', $tags);
    }

    /**
     * Read the Vite manifest file
     * 
     * @return array Parsed manifest data
     * @throws \RuntimeException If manifest file is not found
     */
    private function readManifest(): array
    {
        $manifestPath = $this->getBuildPath($this->config['manifest_file']);
        
        if (!file_exists($manifestPath)) {
            throw new \RuntimeException("Vite manifest file not found at {$manifestPath}");
        }

        return json_decode(file_get_contents($manifestPath), true);
    }

    /**
     * Get full path to a build directory file
     * 
     * @param string $file Filename to resolve
     * @return string Full path to the file
     */
    private function getBuildPath(string $file): string
    {
        return $this->config['build_dir'] . '/' . $file;
    }

    /**
     * Check if a file is JavaScript
     * 
     * @param string $file Filename to check
     * @return bool True if JavaScript file, false otherwise
     */
    private function isJsFile(string $file): bool
    {
        return pathinfo($file, PATHINFO_EXTENSION) === 'js';
    }

    /**
     * Check if a file is CSS
     * 
     * @param string $file Filename to check
     * @return bool True if CSS file, false otherwise
     */
    private function isCssFile(string $file): bool
    {
        return pathinfo($file, PATHINFO_EXTENSION) === 'css';
    }
}