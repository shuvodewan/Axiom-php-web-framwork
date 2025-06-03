<?php

namespace Axiom\Filesystem;

use Axiom\Exception\Exceptions\FileNotFoundException;
use Axiom\Exception\Exceptions\FilesystemException;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\HttpFoundation\File\File;
use Psr\Http\Message\UploadedFileInterface as UploadedFile;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use FilesystemIterator;

class Filesystem 
{
    /**
     * The root directory path for the filesystem.
     */
    protected string $root;

    /**
     * Default permission mappings for files and directories.
     */
    protected array $permissions = [
        'file' => [
            'public' => 0644,
            'private' => 0600,
        ],
        'dir' => [
            'public' => 0755,
            'private' => 0700,
        ],
    ];

    /**
     * Create a new filesystem instance.
     */
    public function __construct(?string $root = null)
    {
        $this->root = $root ? rtrim($root, '/\\') : $this->resolveDefaultRoot();
    }

    /**
     * Resolve the default root directory path.
     */
    protected function resolveDefaultRoot(): string
    {
        return base_path();
    }

    /**
     * Determine if a file or directory exists.
     */
    public function exists(string $path): bool
    {
        return file_exists($this->path($path));
    }

    /**
     * Get the contents of a file.
     *
     * @throws FileNotFoundException
     */
    public function get(string $path): string
    {
        if (!$this->exists($path)) {
            throw new FileNotFoundException("File not found at path: {$path}");
        }

        return file_get_contents($this->path($path));
    }

    /**
     * Write the contents of a file.
     *
     * @param string|resource|StreamInterface $contents
     *
     * @throws FilesystemException
     */
    public function put(string $path, $contents, array $options = []): bool
    {
        try {
            $fullPath = $this->path($path);
            $this->ensureDirectoryExists(dirname($fullPath));

            if ($contents instanceof File || $contents instanceof UploadedFile) {
                return $contents->move(dirname($fullPath), basename($fullPath));
            }

            if ($contents instanceof StreamInterface) {
                $contents = $contents->detach();
            }

            if (is_resource($contents)) {
                $stream = fopen($fullPath, 'w');
                stream_copy_to_stream($contents, $stream);
                fclose($stream);
            } else {
                file_put_contents($fullPath, $contents, $options['lock'] ?? LOCK_EX);
            }

            if (isset($options['visibility'])) {
                $this->setVisibility($path, $options['visibility']);
            }

            return true;
        } catch (\Throwable $e) {
            throw new FilesystemException(
                "Failed to write file at path: {$path}. Error: {$e->getMessage()}", 
                $e->getCode(), 
                $e
            );
        }
    }

    /**
     * Get the visibility for the given path.
     */
    public function getVisibility(string $path): string
    {
        clearstatcache(false, $this->path($path));
        
        return substr(sprintf('%o', fileperms($this->path($path))), -4) >= '0644' 
            ? 'public' 
            : 'private';
    }

    /**
     * Set the visibility for the given path.
     */
    public function setVisibility(string $path, string $visibility): bool
    {
        $fullPath = $this->path($path);
        $mode = is_dir($fullPath) 
            ? $this->permissions['dir'][$visibility] 
            : $this->permissions['file'][$visibility];

        return chmod($fullPath, $mode);
    }

    /**
     * Prepend to a file.
     */
    public function prepend(string $path, string $data): bool
    {
        if ($this->exists($path)) {
            return $this->put($path, $data.$this->get($path));
        }

        return $this->put($path, $data);
    }

    /**
     * Append to a file.
     */
    public function append(string $path, string $data): bool
    {
        return file_put_contents($this->path($path), $data, FILE_APPEND) !== false;
    }

    /**
     * Delete the file at a given path.
     *
     * @param string|array $paths
     */
    public function delete($paths): bool
    {
        $paths = is_array($paths) ? $paths : func_get_args();
        $success = true;

        foreach ($paths as $path) {
            $fullPath = $this->path($path);

            try {
                if (!@unlink($fullPath)) {
                    $success = false;
                }
            } catch (\Throwable $e) {
                $success = false;
            }
        }

        return $success;
    }

    /**
     * Copy a file to a new location.
     */
    public function copy(string $from, string $to): bool
    {
        $this->ensureDirectoryExists(dirname($this->path($to)));

        return copy($this->path($from), $this->path($to));
    }

    /**
     * Move a file to a new location.
     */
    public function move(string $from, string $to): bool
    {
        $this->ensureDirectoryExists(dirname($this->path($to)));

        return rename($this->path($from), $this->path($to));
    }

    /**
     * Get the file size of a given file.
     */
    public function size(string $path): int
    {
        return filesize($this->path($path));
    }

    /**
     * Get the file's last modification time.
     */
    public function lastModified(string $path): int
    {
        return filemtime($this->path($path));
    }

    /**
     * Get an array of all files in a directory.
     */
    public function files(?string $directory = null, bool $recursive = false): array
    {
        return $this->listContents($directory ?? '', $recursive, false);
    }

    /**
     * Get all of the files from the given directory (recursive).
     */
    public function allFiles(?string $directory = null): array
    {
        return $this->files($directory ?? '', true);
    }

    /**
     * Get all of the directories within a given directory.
     */
    public function directories(?string $directory = null, bool $recursive = false): array
    {
        return $this->listContents($directory ?? '', $recursive, true);
    }

    /**
     * Get all (recursive) of the directories within a given directory.
     */
    public function allDirectories(?string $directory = null): array
    {
        return $this->directories($directory ?? '', true);
    }

    /**
     * Create a directory.
     */
    public function makeDirectory(string $path, string $permission="public"): bool
    {
        $fullPath = $this->path($path);

        return is_dir($fullPath) || mkdir($fullPath, $this->permissions['dir'][$permission], true);
    }

    /**
     * Recursively delete a directory.
     */
    public function deleteDirectory(string $directory): bool
    {
        $fullPath = $this->path($directory);

        if (!is_dir($fullPath)) {
            return false;
        }

        $items = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($fullPath, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($items as $item) {
            if ($item->isDir()) {
                rmdir($item->getRealPath());
            } else {
                unlink($item->getRealPath());
            }
        }

        return rmdir($fullPath);
    }

    /**
     * Get the full path for the given relative path.
     */
    public function path(string $path): string
    {
        $path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);

        return $this->root.DIRECTORY_SEPARATOR.ltrim($path, '/\\');
    }

    /**
     * Ensure the directory exists.
     *
     * @throws FilesystemException
     */
    protected function ensureDirectoryExists(string $directory): void
    {
        if (!is_dir($directory) && !$this->makeDirectory($directory)) {
            throw new FilesystemException("Unable to create directory: {$directory}");
        }
    }

    /**
     * List directory contents.
     */
    protected function listContents(string $directory, bool $recursive, bool $directoriesOnly): array
    {
        $fullPath = $this->path($directory);
        $results = [];

        if (!is_dir($fullPath)) {
            return [];
        }

        $iterator = $recursive 
            ? new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($fullPath, FilesystemIterator::SKIP_DOTS),
                RecursiveIteratorIterator::SELF_FIRST
              )
            : new \DirectoryIterator($fullPath);

        foreach ($iterator as $item) {
            if ($item->isDot()) {
                continue;
            }

            if ($directoriesOnly && !$item->isDir()) {
                continue;
            }

            if (!$directoriesOnly && $item->isDir()) {
                continue;
            }

            $relativePath = str_replace($this->root, '', $item->getPathname());
            $results[] = ltrim($relativePath, '/\\');
        }

        return $results;
    }
}