<?php

namespace Tests;

use Panda\Contracts\Http\Kernel;
use Panda\Http\Request;
use Panda\Routing\Controller;
use Panda\Routing\Router;
use Throwable;

/**
 * Class Controller_TestCase
 * @package Tests
 */
class Kernel_TestCase extends Base_TestCase
{
    /**
     * @var Router
     */
    protected static $router;

    /**
     * @param string      $uri
     * @param string      $method
     * @param array       $parameters
     * @param array       $cookies
     * @param array       $files
     * @param array       $server
     * @param string|null $content
     *
     * @return Request
     */
    public function mockRequest($uri = '', $method = Request::METHOD_GET, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
    {
        // Mock request
        $request = parent::mockRequest($uri, $method, $parameters, $cookies, $files, $server, $content);

        // Set request to router and controller
        $this->setRouterRequest($request);

        return $request;
    }

    /**
     * Set the current request to the Router and the Controller
     *
     * @param Request|null $request
     */
    public function setRouterRequest(Request $request = null)
    {
        // Normalize request
        $request = $request ?: $this->getRequest();

        try {
            // Set current request to Router
            self::$router = self::$router ?: $this->getApp()->get(Router::class);
            $this->getApp()->set(Router::class, self::$router);
            self::$router->setCurrentRequest($request);

            // Set Router to Controller
            Controller::setRouter(self::$router);
        } catch (Throwable $ex) {
        }
    }

    /**
     * @param Request|null $request
     *
     * @return null|\Panda\Http\Response
     * @throws \PHPUnit\Framework\AssertionFailedError
     */
    public function handleRequest(Request $request = null)
    {
        try {
            // Normalize request
            $request = $request ?: $this->getRequest();

            /**
             * Make a kernel handler that will handle the incoming request.
             *
             * @var \Panda\Foundation\Http\Kernel $kernel
             */
            $kernel = $this->getApp()->get(Kernel::class);

            /**
             * Handle the current request and get the generated
             * response from the routes.
             */
            return $kernel->handle($request);
        } catch (Throwable $ex) {
            $this->fail($ex->getMessage());
        }

        return null;
    }
}
