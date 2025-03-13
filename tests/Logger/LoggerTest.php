<?php

declare(strict_types=1);

namespace Myposter\Tests\Logger;

use InvalidArgumentException;
use Myposter\Logger\ConsoleLogger;
use Myposter\Logger\FileLogger;
use Myposter\Logger\LoggerFactory;
use Myposter\Logger\LoggerType;
use PHPUnit\Framework\TestCase;

/**
 * @author Walid Chaouch <walid.chaouch500@gmail.com>
 */
final class LoggerTest extends TestCase
{

    private string $logFilePath;
    private FileLogger $fileLogger;
    private ConsoleLogger $consoleLogger;

    protected function setUp(): void
    {
        $this->logFilePath = dirname(__DIR__,2) . '/src/var/log/php/log1.txt';

        $this->fileLogger = new FileLogger($this->logFilePath);
        $this->consoleLogger = new ConsoleLogger();
    }

    protected function tearDown(): void
    {
        // Remove the log file after each test
        if (file_exists($this->logFilePath)) {
            unlink($this->logFilePath);
        }
    }

    /**
     * @return \Generator
     */
    public function dataProviderLoggerFactoryValidTypes(): \Generator
    {
        yield 'FileLogger' => [LoggerType::FILE, FileLogger::class];
        yield 'ConsoleLogger' => [LoggerType::CONSOLE, ConsoleLogger::class];
    }

    /**
     * @return \Generator
     */
    public function dataProviderLoggerFactoryInvalidTypes(): \Generator
    {
        yield 'Invalid Type 1' => ['type 1'];
        yield 'Invalid Type 2' => ['Type 2'];
    }

    /**
     * @return \Generator
     */
    public function dataProviderFileLoggerFunctionality(): \Generator
    {
        yield 'Message 1' => ['FileLogger test message'];
        yield 'Message 2' => ['Test message'];
    }

    /**
     * @dataProvider dataProviderLoggerFactoryValidTypes
     */
    public function testLoggerFactoryWithValidTypes(string $type, string $expectedClass): void
    {
        $logger = LoggerFactory::create($type);
        $this->assertInstanceOf($expectedClass, $logger);
    }

    /**
     * @dataProvider dataProviderLoggerFactoryInvalidTypes
     */
    public function testLoggerFactoryWithInValidTypes(string $type): void
    {
        $this->expectException(InvalidArgumentException::class);
        LoggerFactory::create($type);
    }

    /**
     * @dataProvider dataProviderFileLoggerFunctionality
     */
    public function testFileLoggerFunctionality(string $logMessage): void
    {
        $this->fileLogger->info($logMessage);
        $this->assertFileExists($this->logFilePath);
        $logContents = file_get_contents($this->logFilePath);
        $this->assertStringContainsString($logMessage, $logContents);
    }

    public function testWriteAppendsToFile(): void
    {
        $this->fileLogger->info( "First message");
        $this->fileLogger->info( "Second message");

        $logContent = file_get_contents($this->logFilePath);
        $logLines = explode("\n", trim($logContent));

        $this->assertCount(2, $logLines);
        $this->assertStringContainsString("First message", $logLines[0]);
        $this->assertStringContainsString("Second message", $logLines[1]);
    }

    /**
     * @dataProvider dataProviderFileLoggerFunctionality
     */
    public function testConsoleLoggerFunctionality(string $message): void
    {
        ob_start();
        $this->consoleLogger->error($message);
        $output = ob_get_clean();

        $this->assertStringContainsString($message, $output);
    }
}
