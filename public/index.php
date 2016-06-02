<?php

/**
 * Panda Framework - The lightweight framework
 *
 * @package  PandaPlatform
 * @author   Ioannis Papikas <papikas.ioan@gmail.com>
 */

use Panda\Http\Request;

/**
 * Initialize the application autoloader to take care of all
 * automatic class loads through the entire application.
 */
$app = require_once(__DIR__ . '/../init/autoload.php');

/**
 * Initialize the application including the application initializer.
 * This enables the application to capture requests and send back
 * responses.
 */
$app = require_once(__DIR__ . '/../init/app.php');

/**
 * Run the application to get the request and return the appropriate
 * response. At this point we set the routes folder for the application to
 * handle the incoming request.
 */

/**
 * Make a kernel handler that will handle the incoming request.
 */
$kernel = $app->make(\Panda\Contracts\Http\Kernel::class);

/**
 * Handle the current request and get the generated
 * response from the routes.
 */
$response = $kernel->handle($request = Request::capture());

// Generate the response
$response->send();

// Close the connection
$kernel->terminate($request, $response);