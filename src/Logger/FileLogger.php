<?php

declare(strict_types=1);

namespace Myposter\Logger;

use Myposter\Helper\FileHelper;

class FileLogger extends AbstractLogger
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
} 