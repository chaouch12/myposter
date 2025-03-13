<?php

declare(strict_types=1);

namespace Myposter\Helper;

/**
 * @author Walid Chaouch <walid.chaouch500@gmail.com>
 */
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
} 