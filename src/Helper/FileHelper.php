<?php

declare(strict_types=1);

namespace Myposter\Helper;

use InvalidArgumentException;
use RuntimeException;

class FileHelper
{

    /**
     * Ensures that the directory exists (create if not exist) and the file is writable
     *
     * @throws \RuntimeException If directory cannot be created or file is not writable
     */
    public static function ensureDirectoryAndFile(string $filePath): void
    {
        // Get directory path from file path
        $directory = dirname($filePath);

        if (!is_dir($directory)) {
            if (!mkdir($directory, 0777, true) && !is_dir($directory)) {
                throw new \RuntimeException(
                    sprintf('Directory "%s" could not be created', $directory)
                );
            }
        }

        if (!file_exists($filePath)) {
            if (false === touch($filePath)) {
                throw new \RuntimeException(
                    sprintf('File "%s" could not be created', $filePath)
                );
            }
        }

        if (!is_writable($filePath)) {
            throw new \RuntimeException(
                sprintf('File "%s" is not writable', $filePath)
            );
        }
    }

    function rs_rmdir(string $path, bool $silent = false): void {

        if (!file_exists($path)) {

            if ($silent) {
                return;
            }

            throw new RuntimeException('Path "' . $path . '" not found');

        }

        if (!is_dir($path)) {

            if ($silent) {
                return;
            }

            throw new InvalidArgumentException('Path "' . $path . '" is no directory');

        }

        $handle = @opendir($path);

        if (!$handle) {

            if ($silent) {
                return;
            }

            throw new RuntimeException('Error in PHP opendir()');

        }

        while (($entry = @readdir($handle))) {

            if ($entry == '.' || $entry == '..') {
                continue;
            }

            $tmp = $path . '/' . $entry;

            if (is_dir($tmp)) {
                $this->rs_rmdir($tmp, $silent);
            }

            if (is_file($tmp)) {
                $this->rs_unlink($tmp, $silent);
            }

        }

        @closedir($handle);
        rmdir($path);

    }

    function rs_unlink(string $file, bool $silent = false): void {

        if (!file_exists($file)) {

            if ($silent) {
                return;
            }

            throw new RuntimeException('File "' . $file . '" not found');

        }

        if (!is_file($file)) {

            if ($silent) {
                return;
            }

            throw new InvalidArgumentException('File "' . $file . '" is no file');

        }

        $res = @unlink($file);

        if (!$res) {

            if ($silent) {
                return;
            }

            throw new RuntimeException('Error in PHP unlink(), failed to delete file "' . $file . '"');

        }

    }
} 