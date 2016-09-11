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

use Panda\Http\Response;
use Panda\Routing\Controller;
use Panda\Support\Facades\View;

/**
 * Class BaseController
 *
 * @package App\Controllers
 *
 * @version 0.1
 */
class BaseController extends Controller
{
    /**
     * Get a status page of the application.
     *
     * @param int $statusCode
     *
     * @return mixed
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
}
