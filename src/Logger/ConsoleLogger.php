<?php

declare(strict_types=1);

namespace Myposter\Logger;

class ConsoleLogger extends AbstractLogger
{
    protected function log(string $level, string $message, array $context = []): void
    {
        $formattedMessage = $this->formatMessage($level, $message, $context);
        
        // Use STDERR for error level, STDOUT for others
        if ($level === LogLevel::ERROR) {
            fwrite(STDERR, $formattedMessage . PHP_EOL);
        } else {
            fwrite(STDOUT, $formattedMessage . PHP_EOL);
        }
    }
} 