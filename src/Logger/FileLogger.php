<?php

declare(strict_types=1);

namespace Myposter\Logger;

use Myposter\Helper\FileHelper;

class FileLogger extends Logger
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
        FileHelper::ensureDirectoryAndFile($filePath);
    }

    protected function log(string $level, string $message, array $context = []): void
    {
        $formattedMessage = $this->formatMessage($level, $message, $context);

        file_put_contents(
            $this->filePath,
            $formattedMessage . PHP_EOL,
            FILE_APPEND
        );
    }

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
} 