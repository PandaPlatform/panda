<?php

/**
 * Panda Framework - The lightweight framework
 *
 * @package  PandaPlatform
 * @author   Ioannis Papikas <papikas.ioan@gmail.com>
 */

use \Panda\Http\Request;

/**
 * Initialize the application including the application initializer.
 * The following line will initialize the autoloader and start
 * the application.
 */

$app = require_once(__DIR__.'/../init/app.php');

/**
 * Run the application to get the request and return the appropriate
 * response. At this point we set the routes folder for the application to
 * handle the incoming request.
 */

// Handle the incoming request
$kernel = $app->getService("kernel");

/**
 * Handle the current request and get the generated
 * response from the routes.
 */
$response = $kernel->handle($request = Request::get(), $routesFolder = "/routes/");

// Generate the response
$response->send();

// Close the connection
$kernel->terminate($request, $response);

?>