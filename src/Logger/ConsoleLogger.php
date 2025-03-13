<?php

declare(strict_types=1);

namespace Myposter\Logger;

class ConsoleLogger extends Logger
{
    public const COLORS = [
        LogLevel::DEBUG => '0;33',
        LogLevel::WARN => '1;33',
        LogLevel::INFO => '1;37',
        LogLevel::ERROR => '1;31',
    ];

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

    public function formatMessage(string $level, string $message, array $context = []): string{

        $timestamp = (new \DateTimeImmutable('now', new \DateTimeZone('Europe/Berlin')))->format('Y-m-d H:i:s');
        $contextString = empty($context) ? '' : json_encode($context);
        $levelColored = $this->colored(self::COLORS[$level] ?? '0;37', $level);

        $extraInfo = match (true) {
            isset($context['exception']) && $context['exception'] instanceof \Throwable => $this->formatException($context['exception']),
            !empty($context) => $contextString,
            default => '',
        };

        return sprintf(
                '[%s] - %s - %s%s',
                $timestamp,
                $levelColored,
                $message,
                $extraInfo ? ' - ' . $extraInfo : ''
            ) . PHP_EOL;
    }

    private function colored(string $color, string $text): string {
        return sprintf("\033[%sm%s\033[0m", $color, $text);
    }
} 