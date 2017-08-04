<?php

namespace App\Bootstrap;

use Panda\Contracts\Bootstrap\BootLoader;
use Panda\Foundation\Application;
use Panda\Http\Request;

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
     * AbstractBootLoader constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param Request $request
     */
    abstract public function boot($request = null);

    /**
     * @return Application
     */
    public function getApp(): Application
    {
        return $this->app;
    }
}
