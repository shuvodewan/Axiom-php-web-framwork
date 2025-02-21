<?php

namespace Core\drivers\filesystem;

use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use Aws\S3\S3Client;
use League\Flysystem\Filesystem;

class S3 extends Filesystem
{
    public function __construct(array $config)
    {
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
}
