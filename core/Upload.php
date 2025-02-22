<?php

namespace Core;

use Core\facade\Filesystem;

class Upload
{
    protected $file;
    protected $filesystem;
    public $name;
    public $type;
    public $size;

    public function __construct($file)
    {
        $this->filesystem = Filesystem::instance();
        $this->file = $file;
        $this->name = $file['name'];
        $this->type = $file['type'];
        $this->size = $file['size'];
    }

    public function save($name = null,$path=null)
    {
        
        $extension = pathinfo($this->file['name'], PATHINFO_EXTENSION);
        $fileName = $name ? "$name.$extension" : uniqid() . ".$extension";
        $target =$path?$path . '/' . $fileName:$fileName;
        $content = file_get_contents($this->file['tmp_name']);
        if ($this->filesystem->put($target,$content)) {
            return $target;
        } else {
            return false;
        }
    }

    public function disk(string $name){
        $this->filesystem->disk($name);
        return $this;
    }
}
?>