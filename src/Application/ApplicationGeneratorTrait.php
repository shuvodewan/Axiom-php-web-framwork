<?php

namespace Axiom\Application;

use Axiom\Facade\Str;

/**
 * ApplicationGeneratorTrait
 *
 * Provides reusable functionality for generating application files (e.g., classes, templates) based on stubs.
 * This trait handles tasks such as reading stub files, replacing placeholders, and creating directories.
 */
trait ApplicationGeneratorTrait
{
    /**
     * Map the stub variables present in the stub to their values.
     *
     * This method must be implemented by the class using this trait to define the variables
     * that will replace placeholders in the stub files.
     *
     * @return array The stub variables as key-value pairs
     */
    abstract public function getStubVariables(): array;

    /**
     * Get the source file content by processing the stub file with the stub variables.
     *
     * @param string $item The name of the stub file (without extension)
     * @return string The processed content of the stub file
     */
    public function getSourceFile(string $item): string
    {
        return $this->getStubContents($this->getStubPath($item), $this->getStubVariables());
    }

    /**
     * Get the singular and capitalized class name from a given name.
     *
     * @param string $name The name to process
     * @return string The singular and capitalized class name
     */
    public function getSingularClassName(string $name): string
    {
        return ucwords(Str::singular($name));
    }

    /**
     * Build the directory for the class if it does not already exist.
     *
     * @param string $path The directory path
     * @return string The directory path
     */
    protected function makeDirectory(string $path): string
    {
        if (!$this->filesystem->fileExists($path)) {
            $this->filesystem->createDirectory($path);
        }

        return $path;
    }


    /**
     * Get the path to the stub file.
     *
     * @param string $item The name of the stub file (without extension)
     * @return string The path to the stub file
     */
    public function getStubPath(string $item): string
    {
        return src_path('/Application/Stubs/') . $item . '.stub';
    }

    /**
     * Replace placeholders in the stub file with the provided variables.
     *
     * @param string $stub The path to the stub file
     * @param array $stubVariables The variables to replace in the stub
     * @return string The processed content of the stub file
     */
    public function getStubContents(string $stub, array $stubVariables = []): string
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('{{' . $search . '}}', $replace, $contents);
        }

        return $contents;
    }

    /**
     * Execute the file generation process.
     *
     * This method processes each item in the `$items` array, creates the necessary directories,
     * and writes the generated content to the appropriate files.
     *
     * @param string|null $app The application name
     * @param string|null $name The name of the item to generate
     * @return void
     */
    public function handle(?string $app = null, ?string $name = null): void
    {
        $this->setData($app, $name);

        foreach ($this->items as $item => $path) {
            $dir = $path["dir"];
            $file = $path["file"];

            $this->makeDirectory($dir);

            $contents = $this->getSourceFile($item);

            if (!$this->filesystem->fileExists($dir . $file)) {
                $this->filesystem->write($dir . $file, $contents);
            }
        }
    }
}