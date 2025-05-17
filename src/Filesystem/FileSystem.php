<?php

namespace Axiom\Filesystem;

use Psr\Http\Message\StreamInterface;
use Symfony\Component\HttpFoundation\File\File;
use Psr\Http\Message\UploadedFileInterface as UploadedFile;
use RuntimeException;

class FileSystem 
{
    /**
     * The root directory path for the filesystem
     * @var string
     */
    protected string $root;

    /**
     * Default permission mappings for files and directories
     * @var array
     */
    protected array $permissions = [
        'file' => [
            'public' => 0644,  // -rw-r--r--
            'private' => 0600, // -rw-------
        ],
        'dir' => [
            'public' => 0755,   // drwxr-xr-x
            'private' => 0700, // drwx------
        ],
    ];

    /**
     * Constructor - sets the root directory path
     * @param string $root The root directory path
     */
    public function __construct(?string $root = null)
    {
        $this->root = $root? rtrim($root, '/\\') : base_path();
    }

    /**
     * Get the full path for a given relative path
     * @param string $path The relative path
     * @return string Absolute path
     */
    public function path(string $path): string
    {
        return $this->root.DIRECTORY_SEPARATOR.ltrim($path, '/\\');
    }

    /**
     * Check if a file exists
     * @param string $path Relative path to file
     * @return bool True if file exists
     */
    public function exists(string $path): bool
    {
        return file_exists($this->path($path));
    }

    /**
     * Get file contents
     * @param string $path Relative path to file
     * @return string|null File contents or null if not found
     */
    public function get(string $path): ?string
    {
        if (!$this->exists($path)) {
            return null;
        }

        return file_get_contents($this->path($path)) ?: null;
    }

    /**
     * Get a read stream resource for a file
     * @param string $path Relative path to file
     * @return resource|null Stream resource or null if not found
     */
    public function readStream(string $path)
    {
        if (!$this->exists($path)) {
            return null;
        }

        return fopen($this->path($path), 'r');
    }

    /**
     * Write contents to a file
     * @param string $path Relative path to file
     * @param mixed $contents File contents (string, resource, File object)
     * @param array $options Additional options (e.g., visibility)
     * @return bool True on success
     */
    public function put(string $path, $contents, array $options = []): bool
    {
        $fullPath = $this->path($path);
        $this->ensureDirectoryExists(dirname($fullPath));

        // Handle different content types
        if ($contents instanceof File || $contents instanceof UploadedFile) {
            return $contents->move(dirname($fullPath), basename($fullPath));
        }

        if ($contents instanceof StreamInterface) {
            $stream = fopen($fullPath, 'w');
            stream_copy_to_stream($contents->detach(), $stream);
            fclose($stream);
            return true;
        }

        if (is_resource($contents)) {
            $stream = fopen($fullPath, 'w');
            stream_copy_to_stream($contents, $stream);
            fclose($stream);
            return true;
        }

        // Default string content handling
        $result = file_put_contents($fullPath, $contents, $options['lock'] ?? LOCK_EX);

        // Set visibility if specified
        if ($result !== false && isset($options['visibility'])) {
            $this->setVisibility($path, $options['visibility']);
        }

        return $result !== false;
    }

    /**
     * Store an uploaded file
     * @param string $path Target directory path
     * @param mixed $file Uploaded file (File, UploadedFile, or path)
     * @param array $options Additional options
     * @return string|false Saved file path or false on failure
     */
    public function putFile(string $path, $file = null, array $options = [])
    {
        if (is_null($file)) {
            $file = $path;
            $path = '';
        }

        return $this->putFileAs($path, $file, $file instanceof File ? $file->getFilename() : basename($file), $options);
    }

    /**
     * Store an uploaded file with specific name
     * @param string $path Target directory path
     * @param mixed $file Uploaded file (File, UploadedFile, or path)
     * @param mixed $name Desired filename
     * @param array $options Additional options
     * @return string|false Saved file path or false on failure
     */
    public function putFileAs(string $path, $file, $name = null, array $options = [])
    {
        $stream = null;

        // Handle different file input types
        if ($file instanceof UploadedFile) {
            $stream = fopen($file->getRealPath(), 'r');
            $name = $name ?? $file->getClientFilename();
        } elseif ($file instanceof File) {
            $stream = fopen($file->getRealPath(), 'r');
            $name = $name ?? $file->getFilename();
        } elseif (is_string($file) && is_readable($file)) {
            $stream = fopen($file, 'r');
            $name = $name ?? basename($file);
        } elseif (is_resource($file)) {
            $stream = $file;
        }

        if (!$stream) {
            throw new RuntimeException('Invalid file provided.');
        }

        $fullPath = $this->path(trim($path.'/'.$name, '/'));

        $this->ensureDirectoryExists(dirname($fullPath));

        // Write stream to destination
        $dest = fopen($fullPath, 'w');
        stream_copy_to_stream($stream, $dest);
        fclose($dest);

        if (is_resource($stream)) {
            fclose($stream);
        }

        // Set visibility if specified
        if (isset($options['visibility'])) {
            $this->setVisibility($fullPath, $options['visibility']);
        }

        return $fullPath;
    }

    /**
     * Write to a file using a stream
     * @param string $path Relative file path
     * @param resource $resource Stream resource
     * @param array $options Additional options
     * @return bool True on success
     */
    public function writeStream(string $path, $resource, array $options = []): bool
    {
        return $this->put($path, $resource, $options);
    }

    /**
     * Get file visibility (public/private)
     * @param string $path Relative file path
     * @return string 'public' or 'private'
     */
    public function getVisibility(string $path): string
    {
        clearstatcache(false, $this->path($path));
        return substr(sprintf('%o', fileperms($this->path($path))), -4) >= '0644' ? 'public' : 'private';
    }

    /**
     * Set file visibility
     * @param string $path Relative file path
     * @param string $visibility 'public' or 'private'
     * @return bool True on success
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
     * Prepend content to a file
     * @param string $path Relative file path
     * @param string $data Data to prepend
     * @return bool True on success
     */
    public function prepend(string $path, string $data): bool
    {
        if ($this->exists($path)) {
            return $this->put($path, $data.$this->get($path));
        }

        return $this->put($path, $data);
    }

    /**
     * Append content to a file
     * @param string $path Relative file path
     * @param string $data Data to append
     * @return bool True on success
     */
    public function append(string $path, string $data): bool
    {
        return file_put_contents($this->path($path), $data, FILE_APPEND) !== false;
    }

    /**
     * Delete files
     * @param string|array $paths Single path or array of paths
     * @return bool True if all deletions succeeded
     */
    public function delete($paths): bool
    {
        $paths = is_array($paths) ? $paths : func_get_args();
        $success = true;

        foreach ($paths as $path) {
            $fullPath = $this->path($path);
            if (!file_exists($fullPath)) {
                continue;
            }
            if (!@unlink($fullPath)) {
                $success = false;
            }
        }

        return $success;
    }

    /**
     * Copy a file
     * @param string $from Source path
     * @param string $to Destination path
     * @return bool True on success
     */
    public function copy(string $from, string $to): bool
    {
        $this->ensureDirectoryExists(dirname($this->path($to)));

        return copy($this->path($from), $this->path($to));
    }

    /**
     * Move/rename a file
     * @param string $from Source path
     * @param string $to Destination path
     * @return bool True on success
     */
    public function move(string $from, string $to): bool
    {
        $this->ensureDirectoryExists(dirname($this->path($to)));

        return rename($this->path($from), $this->path($to));
    }

    /**
     * Get file size in bytes
     * @param string $path Relative file path
     * @return int File size in bytes
     */
    public function size(string $path): int
    {
        return filesize($this->path($path));
    }

    /**
     * Get last modified timestamp
     * @param string $path Relative file path
     * @return int Unix timestamp
     */
    public function lastModified(string $path): int
    {
        return filemtime($this->path($path));
    }

    /**
     * Get files in a directory
     * @param string|null $directory Directory path (null for root)
     * @param bool $recursive Include subdirectories
     * @return array List of file paths
     */
    public function files(?string $directory = null, bool $recursive = false): array
    {
        return $this->listContents($directory, $recursive, false);
    }

    /**
     * Get all files recursively
     * @param string|null $directory Starting directory
     * @return array List of file paths
     */
    public function allFiles(?string $directory = null): array
    {
        return $this->listContents($directory, true, false);
    }

    /**
     * Get directories
     * @param string|null $directory Directory path
     * @param bool $recursive Include subdirectories
     * @return array List of directory paths
     */
    public function directories(?string $directory = null, bool $recursive = false): array
    {
        return $this->listContents($directory, $recursive, true);
    }

    /**
     * Get all directories recursively
     * @param string|null $directory Starting directory
     * @return array List of directory paths
     */
    public function allDirectories(?string $directory = null): array
    {
        return $this->listContents($directory, true, true);
    }

    /**
     * Create a directory
     * @param string $path Directory path
     * @return bool True on success
     */
    public function makeDirectory(string $path): bool
    {
        $fullPath = $this->path($path);
        return is_dir($fullPath) || mkdir($fullPath, $this->permissions['dir']['public'], true);
    }

    /**
     * Recursively delete a directory
     * @param string $directory Directory path
     * @return bool True on success
     */
    public function deleteDirectory(string $directory): bool
    {
        $fullPath = $this->path($directory);
        if (!is_dir($fullPath)) {
            return false;
        }

        $items = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($fullPath, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
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
     * Ensure directory exists (helper method)
     * @param string $directory Directory path
     */
    protected function ensureDirectoryExists(string $directory): void
    {
        if (!is_dir($directory)) {
            $this->makeDirectory($directory);
        }
    }

    /**
     * List directory contents (helper method)
     * @param string|null $directory Directory path
     * @param bool $recursive Include subdirectories
     * @param bool $directoriesOnly Only return directories
     * @return array List of paths
     */
    protected function listContents(?string $directory = null, bool $recursive = false, bool $directoriesOnly = false): array
    {
        $fullPath = $this->path($directory ?? '');
        $results = [];

        if (!is_dir($fullPath)) {
            return [];
        }

        $iterator = $recursive 
            ? new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($fullPath, \FilesystemIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::SELF_FIRST
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