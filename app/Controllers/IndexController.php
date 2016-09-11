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
 * Class IndexController
 *
 * @package App\Controllers
 *
 * @version 0.1
 */
class IndexController extends BaseController
{
    /**
     * @return mixed
     */
    public function index()
    {
        return View::load("index")->getOutput();
    }
}
