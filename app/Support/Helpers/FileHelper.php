<?php

namespace App\Support\Helpers;

/**
 * Class FileHelper
 * @package App\Support\Helpers
 */
class FileHelper
{
    /**
     * @param string $directory
     * @param bool   $recursive
     *
     * @return array
     */
    public static function getFilesInDirectory($directory, $recursive = false)
    {
        // Get list of files
        $files = scandir($directory);

        // Remove dot files
        unset($files[array_search('.', $files, true)]);
        unset($files[array_search('..', $files, true)]);

        // Create file list
        $fileList = [];
        foreach ($files as $filePath) {
            // Get full file path
            $fullFilePath = $directory . DIRECTORY_SEPARATOR . $filePath;

            // If path is dir, get inner files
            if ($recursive && is_dir($fullFilePath)) {
                $innerFileList = self::getFilesInDirectory($fullFilePath, $recursive);
                $fileList = array_merge($fileList, $innerFileList);

                // Next
                continue;
            }

            // Add file to list
            $fileList[] = $fullFilePath;
        }

        return $fileList;
    }
}
