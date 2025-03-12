<?php

namespace Core\traits;

use Core\facade\Str;

trait ApplicationGeneratorTrait
{
      /**
    **
    * Map the stub variables present in stub to its value
    *
    * @return array
    *
    */
   public function getStubVariables()
   {
       return [
           'NAMESPACE'         => ucfirst($this->app),
           'CLASS_NAME'        => $this->getSingularClassName($this->name),
       ];
   }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public function getSourceFile($item)
    {   
        return $this->getStubContents($this->getStubPath($item), $this->getStubVariables());
    }


    /**
     * Return the Singular Capitalize Name
     * @param $name
     * @return string
     */
    public function getSingularClassName($name)
    {
        return ucwords(Str::singular($name));
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (!$this->filesystem->fileExists($path)) {
            $this->filesystem->createDirectory($path);
        }
    
        return $path;
    
    }

    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param $stub
     * @param array $stubVariables
     * @return bool|mixed|string
     */
    public function getStubContents($stub , $stubVariables = [])
    {
        $contents = file_get_contents($stub);
        foreach ($stubVariables as $search => $replace)
        {
            $contents = str_replace('{{'.$search.'}}' , $replace, $contents);
        }

        return $contents;

    }


    /**
     * Execute the console command.
     */
    public function handle($app=null, $name=null)
    {
        $this->setData($app,$name);

        foreach($this->items as $item=>$path){
            $path = $path;
            $this->makeDirectory($path["dir"]);
    
            $contents = $this->getSourceFile($item);
            if (!$this->filesystem->fileExists($path["dir"].$path['file'])) {
               
                $this->filesystem->write($path["dir"].$path['file'], $contents);
            }else{
               
            }
        }

    }

}