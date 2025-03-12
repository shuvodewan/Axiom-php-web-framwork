<?php

namespace Core\console\commands;

use Core\console\Command;
use Core\drivers\filesystem\Local;
use Core\facade\Str;
use Core\traits\ApplicationGeneratorTrait;

class ModelGeneratorCommand extends Command
{
    use ApplicationGeneratorTrait;

    protected $app;
    protected $filesystem;
    protected $name;
    protected $items;


    protected function validator():array
    {
       return [
        'name'=>'required|max:50'
       ]; 
    }

    protected  function setData($app=null, $name=null){
        $this->info('Generating models...');

        $this->filesystem = new Local(['root'=>app_path()]);
        $this->app = $app??$this->argument('app');
        $this->name = $name??$this->argument('name');
        $this->items=[
            "model"=>[
                "dir"=>ucfirst($this->app).'/models/',
                "file"=>$this->getSingularClassName($this->name) .'.php'
            ],
        ];
    }


    /**
     * Return the stub file path
     * @return string
     *
     */
    public function getStubPath($item)
    {
        return core_path('/application/stubs/').$item.'.stub';
    }

}