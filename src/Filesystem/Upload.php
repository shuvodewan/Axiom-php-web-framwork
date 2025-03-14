<?php

namespace Axiom\Filesystem;

use InvalidArgumentException;
use RuntimeException;

/**
 * Class Upload
 *
 * Handles file uploads and provides methods to save uploaded files to a specified disk.
 */
class Upload
{
    /**
     * The uploaded file data.
     *
     * @var array<string, mixed>
     */
    protected array $file;

    /**
     * The filesystem manager instance.
     *
     * @var FileManager
     */
    protected FileManager $filesystem;

    /**
     * The name of the uploaded file.
     *
     * @var string
     */
    protected string $name;

    /**
     * The MIME type of the uploaded file.
     *
     * @var string
     */
    protected string $type;

    /**
     * The size of the uploaded file in bytes.
     *
     * @var int
     */
    protected int $size;

    /**
     * Upload constructor.
     *
     * Initializes the Upload class with the uploaded file data.
     *
     * @param array<string, mixed> $file The uploaded file data from $_FILES.
     * @param FileManager $filesystem The filesystem manager instance.
     * @throws InvalidArgumentException If the file data is invalid.
     */
    public function __construct(array $file)
    {
        if (!isset($file['name'], $file['type'], $file['size'], $file['tmp_name'])) {
            throw new InvalidArgumentException('Invalid file data provided.');
        }

        $this->filesystem = new FileManager();
        $this->file = $file;
        $this->name = $file['name'];
        $this->type = $file['type'];
        $this->size = $file['size'];
    }

    /**
     * Save the uploaded file to the specified disk.
     *
     * @param string|null $name The custom name for the file (without extension). If null, a unique name is generated.
     * @param string|null $path The directory path where the file should be saved. If null, the file is saved in the root.
     * @return string The path to the saved file.
     * @throws RuntimeException If the file cannot be read or saved.
     */
    public function save(?string $name = null, ?string $path = null): string
    {
        $extension = pathinfo($this->file['name'], PATHINFO_EXTENSION);
        $fileName = $name ? preg_replace('/[^a-zA-Z0-9\-_.]/', '', $name) . ".$extension" : uniqid() . ".$extension";
        $target = $path ? "$path/$fileName" : $fileName;

        $content = file_get_contents($this->file['tmp_name']);
        if ($content === false) {
            throw new RuntimeException('Failed to read the uploaded file.');
        }

        if (!$this->filesystem->put($target, $content)) {
            throw new RuntimeException('Failed to save the file.');
        }

        return $target;
    }

    /**
     * Set the disk where the file should be saved.
     *
     * @param string $name The name of the disk.
     * @return self
     */
    public function disk(string $name): self
    {
        $this->filesystem->disk($name);
        return $this;
    }
}