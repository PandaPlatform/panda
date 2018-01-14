<?php

/*
 * This file is part of the Panda framework.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controllers;

use InvalidArgumentException;
use Panda\Http\Response;
use Panda\Routing\Controller;
use Panda\Support\Facades\View;
use UnexpectedValueException;

/**
 * Class BaseController
 * @package App\Controllers
 */
class BaseController extends Controller
{
    /**
     * Get a status page of the application.
     *
     * @param int $statusCode
     *
     * @return mixed
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function getPageByStatus($statusCode)
    {
        // Load page output
        $output = View::load('__pages/' . $statusCode)->getOutput();

        // Create and return response
        return (new Response())
            ->setStatusCode($statusCode)
            ->setContent($output);
    }

    /**
     * @param Response $response
     *
     * @return Response
     */
    public function finalizeResponse(Response $response)
    {
        return $response;
    }
}
