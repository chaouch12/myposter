<?php

namespace Myposter\Logger;

/**
 * @author Walid Chaouch <walid.chaouch500@gmail.com>
 */
abstract class Logger implements LoggerInterface
{
    abstract protected function log(string $level, string $message, array $context = []): void;

    abstract protected function formatMessage(string $level, string $message, array $context = []): string;

    public function debug(string $message, array $context = []): void
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }

    public function info(string $message, array $context = []): void
    {
        $this->log(LogLevel::INFO, $message, $context);
    }

    public function warn(string $message, array $context = []): void
    {
        $this->log(LogLevel::WARN, $message, $context);
    }

    public function error(string $message, array $context = []): void
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    protected function formatException(\Throwable $exception): string
    {
        return sprintf(
            "\nException: %s\nMessage: %s\nStack trace:\n%s",
            get_class($exception),
            $exception->getMessage(),
            $exception->getTraceAsString()
        );
    }
} 