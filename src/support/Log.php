<?php

namespace Core\support;

use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;

class Log
{
    static  $instance;
    private $logger;
    private $path;

    public function __construct($channelName =null)
    {
        $this->logger = new Logger($channelName??config('app.name'));
        $this->path = storage_path('/logs');
        $this->checkStorage();
        $handler = $this->setHandler();
        $this->logger->pushHandler($handler);

        $this->setInstance($this);
    }


    static function setInstance($instance){
        self::$instance = $instance;
    }

    static function getInstance(){
        return self::$instance;
    }

    private function checkStorage(){
        if (!is_dir($this->path)) {
            mkdir($this->path, 0755, true);
        }
    }

    private function setHandler(){
        $handler = new RotatingFileHandler("{$this->path}/".config('log.name').".log", config('log.age'), Logger::DEBUG); // Keep logs for 7 days
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

    public function info($message, array $context = [])
    {
        $this->logger->info($message, $context);
    }

    public function error($message, array $context = [])
    {
        $this->logger->error($message, $context);
    }

    public function warning($message, array $context = [])
    {
        $this->logger->warning($message, $context);
    }
}