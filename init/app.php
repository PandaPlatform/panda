<?php

/**
 * Create the Panda application and provide the base path and
 * the runtime configuration.
 */

$app = new Panda\Foundation\Application(
    $basePath = realpath(__DIR__ . '/../'),
    $runtimeConfig = "default"
);

/**
 * Return the application to the caller to start the application.
 */
return $app;