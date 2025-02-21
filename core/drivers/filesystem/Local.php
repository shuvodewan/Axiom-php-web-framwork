<?php

namespace Core\drivers\filesystem;

use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;

class Local extends Filesystem
{
    public function __construct(string $root)
    {
        parent::__construct(new LocalFilesystemAdapter($root));
    }
}
