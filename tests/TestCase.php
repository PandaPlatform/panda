<?php

/*
 * This file is part of the Panda framework.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests;

use Panda\Bootstrap\Environment;
use Panda\Bootstrap\FacadeRegistry;
use Panda\Bootstrap\Localization;
use Panda\Bootstrap\Logging;
use Panda\Bootstrap\Session;
use Panda\Config\Configuration;
use Panda\Foundation\Application;
use Panda\Foundation\Bootstrap\BootstrapRegistry;
use Panda\Http\Request;
use Panda\Support\Helpers\ArrayHelper;
use PHPUnit_Framework_TestCase;

/**
 * Class TestCase
 * @package Tests
 */
class TestCase extends Base_TestCase
{
    /**
     * @throws \PHPUnit_Framework_AssertionFailedError
     */
    public function testCase()
    {
        $this->assertTrue(true);
    }
}
