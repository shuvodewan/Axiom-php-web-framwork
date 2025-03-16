<?php

namespace Axiom\Http;

use Axiom\Filesystem\Upload;
use InvalidArgumentException;

/**
 * Trait FileTrait
 *
 * Provides functionality to handle file uploads in a request class.
 * Processes the `$_FILES` superglobal, organizes uploaded files, and provides methods to access them.
 */
trait FileTrait
{
    /**
     * The processed file uploads.
     *
     * @var array<string, Upload|array<Upload>>
     */
    protected array $files = [];

    /**
     * Process the uploaded files from the $_FILES superglobal.
     *
     * @return void
     * @throws InvalidArgumentException If the file data is invalid.
     */
    protected function setFiles(): void
    {
        foreach ($_FILES as $column => $file) {
            if (is_array($file['name'])) {
                foreach ($file['name'] as $index => $name) {
                    if (!empty($name)) {
                        $this->files[$column][] = new Upload([
                            'name'     => $file['name'][$index],
                            'type'     => $file['type'][$index],
                            'tmp_name' => $file['tmp_name'][$index],
                            'error'    => $file['error'][$index],
                            'size'     => $file['size'][$index],
                        ]);
                    }
                }
            } else {
                if (!empty($file['name'])) {
                    $this->files[$column] = new Upload($file);
                }
            }
        }
    }

    /**
     * Get all processed files.
     *
     * @return array<string, Upload|array<Upload>>
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * Get all files for a specific input name.
     *
     * @param string $name The input name.
     * @return Upload[]|Upload|null The files for the input name, or null if not found.
     */
    public function files(string $name): array|Upload|null
    {
        return $this->files[$name] ?? null;
    }

    /**
     * Get the first file for a specific input name.
     *
     * @param string $name The input name.
     * @return Upload|null The first file for the input name, or null if not found.
     */
    public function file(string $name): ?Upload
    {
        $files = $this->files[$name] ?? null;

        if (is_array($files)) {
            return $files[0] ?? null;
        }

        return $files;
    }
}