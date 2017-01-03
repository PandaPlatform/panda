<?php

/*
 * This file is part of the Panda framework.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Panda\Http\Request;

/**
 * Initialize the application autoloader to take care of all
 * automatic class loads through the entire application.
 */
require_once __DIR__ . '/../boot/autoload.php';

/**
 * Initialize the application including the application initializer.
 * This enables the application to capture requests and send back
 * responses.
 */
$app = require_once __DIR__ . '/../boot/app.php';

/**
 * Run the application to get the request and return the appropriate
 * response. At this point we set the routes folder for the application to
 * handle the incoming request.
 */

/**
 * Make a kernel handler that will handle the incoming request.
 *
 * @var \Panda\Foundation\Http\Kernel $kernel
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
