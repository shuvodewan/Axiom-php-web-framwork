<?php

namespace Axiom\Core;

use Axiom\Traits\InstanceTrait;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;

/**
 * Logging utility class.
 *
 * This class provides a simple interface for logging messages with different severity levels.
 * It uses the Monolog library under the hood and supports rotating log files.
 */
class Log
{
    use InstanceTrait;

    /** @var Logger Monolog logger instance. */
    private Logger $logger;

    /** @var string Path to the log storage directory. */
    private string $path;

    /**
     * Constructor.
     *
     * Initializes the logger with a channel name and sets up the log storage directory.
     *
     * @param string|null $channelName The name of the logging channel. Defaults to the application name from config.
     */
    public function __construct(?string $channelName = null)
    {
        $this->logger = new Logger($channelName ?? config('app.name'));
        $this->path = storage_path('/logs');
        $this->checkStorage();
        $handler = $this->setHandler();
        $this->logger->pushHandler($handler);

        self::setInstance($this);
    }

    /**
     * Ensures the log storage directory exists.
     *
     * Creates the log storage directory if it does not already exist.
     */
    private function checkStorage(): void
    {
        if (!is_dir($this->path)) {
            mkdir($this->path, 0755, true);
        }
    }

    /**
     * Configures and returns a RotatingFileHandler for the logger.
     *
     * @return RotatingFileHandler The configured handler.
     */
    private function setHandler(): RotatingFileHandler
    {
        $handler = new RotatingFileHandler(
            "{$this->path}/" . config('log.name') . ".log",
            config('log.age'),
            Logger::DEBUG
        );
        $handler->setFilenameFormat('{date}_{filename}', 'Y-m-d');
        $formatter = new LineFormatter(
            "[%datetime%] %level_name%: %message% %context%\n",
            null,
            true,
            true
        );
        $handler->setFormatter($formatter);
        return $handler;
    }

    /**
     * Logs an informational message.
     *
     * @param string $message The log message.
     * @param array $context Additional context data.
     */
    public function info(string $message, array $context = []): void
    {
        $this->logger->info($message, $context);
    }

    /**
     * Logs an error message.
     *
     * @param string $message The log message.
     * @param array $context Additional context data.
     */
    public function error(string $message, array $context = []): void
    {
        $this->logger->error($message, $context);
    }

    /**
     * Logs a warning message.
     *
     * @param string $message The log message.
     * @param array $context Additional context data.
     */
    public function warning(string $message, array $context = []): void
    {
        $this->logger->warning($message, $context);
    }
}