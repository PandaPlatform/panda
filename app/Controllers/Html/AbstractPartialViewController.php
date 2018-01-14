<?php

/*
 * This file is part of the Panda framework.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controllers\Html;

use Panda\Foundation\Application;
use Panda\Jar\Http\Response;
use Panda\Jar\Model\Content\ResponseContent;
use Panda\Jar\Model\Header\ResponseHeader;
use Panda\Localization\Translator;
use Panda\Ui\Html\Factories\HTMLFactoryInterface;
use Panda\Ui\Html\HTMLDocument;
use Psr\Log\LoggerInterface;

/**
 * Class AbstractPartialViewController
 * @package App\Controllers\Html
 */
abstract class AbstractPartialViewController extends AbstractViewController
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * AbstractPartialViewController constructor.
     *
     * @param Application          $app
     * @param LoggerInterface      $logger
     * @param Translator           $translator
     * @param HTMLFactoryInterface $HTMLFactory
     *
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \InvalidArgumentException
     */
    public function __construct(Application $app, LoggerInterface $logger, Translator $translator, HTMLFactoryInterface $HTMLFactory)
    {
        parent::__construct($app, $logger, $translator, $HTMLFactory);
        $this->response = new Response();

        // Set HTMLDocument to HTMLFactory
        $HTMLDocument = $this->getApp()->get(HTMLDocument::class);
        $this->getHTMLFactory()->setHTMLDocument($HTMLDocument);
    }

    /**
     * @param ResponseContent[] $contents
     * @param ResponseHeader[]  $headers
     *
     * @return Response
     */
    public function getAsyncResponse($contents = [], $headers = [])
    {
        // Add response contents
        foreach ($contents as $content) {
            $this->getResponse()->addResponseContent($content);
        }

        // Add response headers
        foreach ($headers as $header) {
            $this->getResponse()->addResponseHeader($header);
        }

        // Get async response
        return $this->getResponse();
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }
}
