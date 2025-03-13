<?php

declare(strict_types=1);

namespace Myposter\Logger;

/**
 * @author Walid Chaouch <walid.chaouch500@gmail.com>
 */
interface LoggerInterface
{
    public function debug(string $message, array $context = []): void;
    public function info(string $message, array $context = []): void;
    public function warn(string $message, array $context = []): void;
    public function error(string $message, array $context = []): void;
} 