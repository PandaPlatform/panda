<?php

/*
 * This file is part of the Panda framework.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Bootstrap;

use Panda\Config\Parsers\ConfigurationParser;
use Panda\Support\Configuration\Parsers\JsonParser;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BaseController
 * @package App\Controllers
 */
class Configuration extends AbstractBootLoader
{
    /**
     * @param Request $request
     */
    public function boot($request = null)
    {
        $this->getApp()->set(ConfigurationParser::class, \DI\object(JsonParser::class));
    }
}
