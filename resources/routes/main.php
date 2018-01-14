<?php

/*
 * This file is part of the Panda framework.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Support\Helpers\FileHelper;

/**
 * Load all route files in the current folder.
 *
 * If you wish to extend this functionality, comment out the code
 * below and add your own Routes.
 */

// Get files in the current folder
$files = FileHelper::getFilesInDirectory(__DIR__, true);
foreach ($files as $filePath) {
    // Skip current file
    if (basename($filePath) == 'main.php') {
        continue;
    }

    // Require route file
    require $filePath;
}
