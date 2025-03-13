<?php

declare(strict_types=1);

namespace Myposter\Logger;
use InvalidArgumentException;

/**
 * @author Walid Chaouch <walid.chaouch500@gmail.com>
 */
class LoggerFactory
{
    /**
     * @throws InvalidArgumentException
     */
    public static function create(string $type): LoggerInterface
    {
        return match ($type) {
            LoggerType::FILE => new FileLogger(dirname(__DIR__) . '/var/log/php/log.text'),
            LoggerType::CONSOLE => new ConsoleLogger(),
            default => throw new InvalidArgumentException("Invalid logger type: $type"),
        };
    }
}
