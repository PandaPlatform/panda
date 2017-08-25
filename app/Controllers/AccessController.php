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

use App\Exceptions\UnauthorizedException;

/**
 * Class AccessController
 * @package App\Controllers
 */
abstract class AccessController extends BaseController
{
    /**
     * @throws UnauthorizedException
     */
    abstract public function checkAccessWithRequest();
}
