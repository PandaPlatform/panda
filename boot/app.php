<?php

/*
 * This file is part of the Panda framework.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$app = new Panda\Foundation\Application(
    $basePath = realpath(__DIR__ . '/../')
);

/**
 * Return the application to the caller to start the application.
 */
return $app;
