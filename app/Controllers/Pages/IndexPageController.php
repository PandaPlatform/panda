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

use App\Controllers\Html\Layouts\PlainLayoutViewController;

/**
 * Class IndexPageController
 * @package App\Controllers\Pages
 */
class IndexPageController extends PlainLayoutViewController
{
    /**
     * @return string
     * @throws \Exception
     * @throws \InvalidArgumentException
     */
    public function index()
    {
        $this->build('Panda', 'index', '', 'container');

        return $this->getPageResponse();
    }
}
