<?php

namespace Core;
class Upload
{
    protected $uploadPath;
    protected $dir;
    protected $file;
    protected $disk;
    public $name;
    public $type;
    public $size;

    public function __construct($file)
    {
        $this->disk = config('disk.default');
        $this->file = $file;
        $this->name = $file['name'];
        $this->type = $file['type'];
        $this->size = $file['size'];
    }

    public function save($name = null,$path=null)
    {
        $dir = config('disk'.'.'.$this->disk.'.path') . $path;

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $extension = pathinfo($this->file['name'], PATHINFO_EXTENSION);
        $fileName = $name ? "$name.$extension" : uniqid() . ".$extension";
        $target = $dir . '/' . $fileName;
        if (move_uploaded_file($this->file['tmp_name'], $target)) {
            return  $path .'/'. $fileName;
        } else {
            return false;
        }
    }

    public function disk($diskName){
        $this->disk=$diskName;
        return $this;
    }
}
?>