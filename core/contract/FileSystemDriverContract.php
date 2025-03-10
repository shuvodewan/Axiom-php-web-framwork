<?php

namespace Core\contract;

interface FileSystemDriverContract
{
    public function getUrl(string $path);
}