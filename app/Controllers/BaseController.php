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

use App\Exceptions\ForbiddenException;
use App\Exceptions\OperationNotImplementedException;
use App\Exceptions\RecordNotFoundException;
use App\Exceptions\UnauthorizedException;
use App\Helpers\LoggerHelper;
use InvalidArgumentException;
use Panda\Foundation\Application;
use Panda\Http\Request;
use Panda\Http\Response;
use Panda\Log\Logger;
use Panda\Routing\Controller;
use Panda\Support\Helpers\ArrayHelper;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Throwable;

/**
 * Class BaseController
 * @package App\Controllers
 */
class BaseController extends Controller
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var SymfonyResponse
     */
    private $currentResponse;

    /**
     * BaseController constructor.
     *
     * @param Application     $app
     * @param LoggerInterface $logger
     */
    public function __construct(Application $app, LoggerInterface $logger)
    {
        parent::__construct($app);
        $this->logger = $logger;
    }

    /**
     * @param Throwable       $exception
     * @param SymfonyResponse $response
     * @param array           $extraResponseContent
     *
     * @return Response|JsonResponse|SymfonyResponse
     * @throws InvalidArgumentException
     */
    public function handleException(Throwable $exception, SymfonyResponse $response = null, $extraResponseContent = [])
    {
        // Initialize
        $statusCode = 500;
        $responseContent = ['status' => false];

        try {
            throw $exception;
        } catch (InvalidArgumentException $ex) {
            $statusCode = 400;
            $responseContent['error'] = $ex->getMessage();
        } catch (UnauthorizedException $ex) {
            $statusCode = 401;
            $responseContent['error'] = $ex->getMessage();
        } catch (ForbiddenException $ex) {
            $statusCode = 403;
            $responseContent['error'] = $ex->getMessage();
        } catch (RecordNotFoundException $ex) {
            $statusCode = 404;
            $responseContent['error'] = $ex->getMessage();
        } catch (OperationNotImplementedException $ex) {
            $statusCode = 501;
            $responseContent['error'] = $ex->getMessage();
        } catch (Throwable $ex) {
            // Log error
            LoggerHelper::logThrowable($this->getLogger(), $ex, Logger::ERROR);

            // Set response
            $statusCode = 500;
            $responseContent['error'] = 'An unexpected error has occurred. Please try again. If the error continues to appear, please contact our support.';
        } finally {
            // Append extra response content
            $responseContent = ArrayHelper::merge($responseContent, $extraResponseContent);

            // Set code and json response content
            $response = $response ?: $this->getCurrentResponse();
            $response->setStatusCode($statusCode)->setJson(json_encode($responseContent));
        }

        return $response;
    }

    /**
     * @param Response|SymfonyResponse $response
     *
     * @return Response|SymfonyResponse
     */
    public function finalizeResponse(SymfonyResponse $response = null)
    {
        return $response ?: $this->getCurrentResponse();
    }

    /**
     * @param Request|null $request
     *
     * @return array
     * @throws \LogicException
     */
    public function getArgumentsAsArray(Request $request = null)
    {
        // Get current request
        $request = $request ?: $this->getCurrentRequest();

        // Check if request is json
        $jsonData = $request->getPayloadJSON()->all();
        $arrayData = $request->request->all();

        return $jsonData ?: $arrayData;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param LoggerInterface $logger
     *
     * @return BaseController
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * @return SymfonyResponse|JsonResponse|Response
     */
    public function getCurrentResponse()
    {
        return $this->currentResponse ?: new JsonResponse();
    }

    /**
     * @param SymfonyResponse $currentResponse
     */
    public function setCurrentResponse(SymfonyResponse $currentResponse)
    {
        $this->currentResponse = $currentResponse;
    }
}
