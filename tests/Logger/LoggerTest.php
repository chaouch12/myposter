<?php

declare(strict_types=1);

namespace Myposter\Tests\Logger;

use Myposter\Logger\FileLogger;
use Myposter\Production\FramedPoster;
use Myposter\Production\State\Framed;
use Myposter\Production\State\GiftWrapped;
use Myposter\Production\State\Ordered;
use Myposter\Production\State\Printed;
use Myposter\Production\State\Shipped;
use Myposter\Production\State\Sliced;
use Myposter\Production\State\StateInterface;
use PHPUnit\Framework\TestCase;

final class LoggerTest extends TestCase
{

    private string $logFilePath;
    private FileLogger $fileLogger;

    protected function setUp(): void
    {
        $this->logFilePath = dirname(__DIR__) . '/var/log/php/log.txt';
        $this->fileLogger = new FileLogger($this->logFilePath);
    }

    protected function tearDown(): void
    {
        // Remove the log file after each test
        if (file_exists($this->logFilePath)) {
            unlink($this->logFilePath);
        }
    }

    // test factory with valid data / 2. with invalid Data
    // test FileLogger
    // test ConsoleLogger

    public function testFileLoggerCreatesLogFile(): void
    {
        $this->fileLogger->info('Test message');

        $this->assertFileExists($this->logFilePath);
        $logContents = file_get_contents($this->logFilePath);
        $this->assertStringContainsString('Test message', $logContents);
    }

    /**
     * @return \Generator
     */
    public function dataProviderGetPosterFramed(): \Generator
    {
        yield [
            'default' => [
                new Ordered(),
                new Printed(),
                new Sliced(),
                new Framed(),
                new Shipped(),
            ],
            false,
        ];

        yield [
            'stateGiftWrapped' => [
                new Ordered(),
                new Printed(),
                new Sliced(),
                new Framed(),
                new GiftWrapped(),
                new Shipped(),
            ],
            true,
        ];
    }
}
