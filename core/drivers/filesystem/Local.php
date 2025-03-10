<?php

namespace Core\drivers\filesystem;

use Core\contract\FileSystemDriverContract;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;

class Local extends Filesystem implements FileSystemDriverContract
{
    protected $config=[]; 

    public function __construct(array $config)
    {
        $this->config = $config;

        parent::__construct(new LocalFilesystemAdapter($config['root']));
    }

    public function getUrl(string $path){
        if(isset($this->config['url'])){
            return $this->config['url'] . '/' . trim($path,'/');
        }else{
            $path;
        }
    }
}
