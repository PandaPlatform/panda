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

use App\Bootstrap\Configuration;
use Panda\Bootstrap\Environment;
use Panda\Bootstrap\FacadeRegistry;
use Panda\Bootstrap\Localization;
use Panda\Bootstrap\Logging;
use Panda\Bootstrap\Session;
use Panda\Foundation\Application;
use Panda\Foundation\Bootstrap\BootstrapRegistry;
use Panda\Http\Request;
use Panda\Support\Helpers\ArrayHelper;
use PHPUnit_Framework_TestCase;

/**
 * Class Base_TestCase
 * @package Tests
 */
class Base_TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var string
     */
    protected $environment = 'development';

    /**
     * @var Request
     */
    protected $request = null;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     * It also sets up the test environment.
     */
    protected function setUp()
    {
        // Initialize application
        /** @var Application $app */
        $app = require __DIR__ . '/../Boot/app.php';

        // Set BootstrapRegistry
        /** @var BootstrapRegistry $registry */
        $registry = $app->make(BootstrapRegistry::class);
        $registryItems = $registry->getItems();
        $testingBootLoaders = [
            Environment::class,
            Configuration::class,
            Localization::class,
            FacadeRegistry::class,
            Session::class,
            Logging::class,
        ];
        $registry->setItems(ArrayHelper::merge($registryItems, $testingBootLoaders));

        // Set environment and boot application
        $app->setEnvironment($this->getEnvironment())->boot($this->getRequest(), $registry->getItems());

        parent::setUp();
    }

    /**
     * @return Application
     */
    public function getApp()
    {
        return $this->app;
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @param string $environment
     *
     * @return Base_TestCase
     */
    public function setEnvironment(string $environment)
    {
        $this->environment = $environment;

        return $this;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param Request $request
     *
     * @return Base_TestCase
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }
}
