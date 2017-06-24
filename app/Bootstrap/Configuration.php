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

use Panda\Config\ConfigurationParser;
use Panda\Contracts\Bootstrap\BootLoader;
use Panda\Foundation\Application;
use Panda\Support\Configuration\Parsers\JsonParser;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BaseController
 * @package App\Controllers
 */
class Configuration implements BootLoader
{
    /**
     * @var Application
     */
    private $app;

    /**
     * Configuration constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Boot the BootLoader.
     *
     * @param Request $request
     */
    public function boot($request)
    {
        $this->app->set(ConfigurationParser::class, \DI\object(JsonParser::class));
    }
}
