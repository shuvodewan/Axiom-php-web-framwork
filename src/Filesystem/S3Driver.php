<?php

namespace Axiom\Filesystem;

use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use Aws\S3\S3Client;
use League\Flysystem\Filesystem;

/**
 * Class S3Driver
 *
 * Implements an S3 filesystem driver using Flysystem.
 * This driver allows interaction with AWS S3 or S3-compatible storage and provides URL generation for stored files.
 */
class S3Driver extends Filesystem implements FileSystemDriverContract
{
    /**
     * Configuration options for the S3 filesystem driver.
     *
     * @var array
     */
    protected array $config = []; 

    /**
     * S3 constructor.
     *
     * Initializes the S3 filesystem driver with the provided configuration.
     *
     * @param array $config Configuration options for the driver.
     */
    public function __construct(array $config)
    {
        $this->config = $config;

        $client = new S3Client([
            'credentials' => [
                'key'    => $config['key'] ?? '',
                'secret' => $config['secret'] ?? '',
            ],
            'region'      => $config['region'] ?? 'us-east-1',
            'version'     => 'latest',
            'endpoint'    => $config['endpoint'] ?? null,
            'use_path_style_endpoint' => $config['use_path_style_endpoint'] ?? false,
        ]);
    
        $adapter = new AwsS3V3Adapter($client, $config['bucket'] ?? '');
        parent::__construct($adapter);
    }

    /**
     * Get the URL for a given file path.
     *
     * If a base URL is configured, it prepends the base URL to the file path.
     * Otherwise, it returns the file path as-is.
     *
     * @param string $path The file path.
     * @return string The full URL or file path.
     */
    public function getUrl(string $path) :string
    {
        if (isset($this->config['url'])) {
            return rtrim($this->config['url'], '/') . '/' . ltrim($path, '/');
        }

        return $path;
    }
}
