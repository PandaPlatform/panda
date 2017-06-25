<?php

/*
 * This file is part of the Panda framework.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controllers\Pages;

use App\Controllers\Html\PageController;

/**
 * Class IndexController
 * @package App\Controllers
 */
class IndexController extends PageController
{
    /**
     * @return string
     * @throws \DI\NotFoundException
     * @throws \Exception
     * @throws \InvalidArgumentException
     */
    public function index()
    {
        $this->build('Panda', 'index', '', 'container');

        return $this->getPageResponse();
    }
}
