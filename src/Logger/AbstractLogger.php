<?php

namespace Myposter\Logger;

abstract class AbstractLogger implements LoggerInterface
{
    abstract protected function log(string $level, string $message, array $context = []): void;

    protected function formatMessage(string $level, string $message, array $context = []): string
    {
        $timestamp = (new \DateTimeImmutable('now', new \DateTimeZone('Europe/Berlin')))->format('Y-m-d H:i:s');
        $contextString = empty($context) ? '' : json_encode($context);

        if (empty($context)) {
            return "[$timestamp] [{$level}] $message";
        }

        if (array_key_exists('exception', $context) && $context['exception'] instanceof \Throwable) {
            $exceptionString = $this->formatException($context['exception']);
            return "[$timestamp] [{$level}] $message $exceptionString";
        }

        return "[$timestamp] [{$level}] $message $contextString";
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
} 