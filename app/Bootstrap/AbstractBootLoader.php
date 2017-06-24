<?php

namespace App\Bootstrap;

use Panda\Contracts\Bootstrap\BootLoader;
use Panda\Foundation\Application;

/**
 * Class AbstractBootLoader
 * @package App\Bootstrap
 */
abstract class AbstractBootLoader implements BootLoader
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * AbstractBootstrapper constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Boot the bootstrapper.
     *
     * @param \Panda\Http\Request $request
     */
    abstract public function boot($request);

    /**
     * @return Application
     */
    public function getApp(): Application
    {
        return $this->app;
    }
}
