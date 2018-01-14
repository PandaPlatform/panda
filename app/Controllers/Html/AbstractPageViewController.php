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

use App\Html\PageTemplate;
use Exception;
use InvalidArgumentException;
use Panda\Foundation\Application;
use Panda\Http\Response;
use Panda\Localization\Translator;
use Panda\Ui\Html\Factories\HTMLFactoryInterface;
use Panda\Ui\Html\HTMLDocument;
use Psr\Log\LoggerInterface;

/**
 * Class AbstractPageViewController
 * @package App\Controllers\Html
 */
abstract class AbstractPageViewController extends AbstractViewController
{
    /**
     * @var PageTemplate
     */
    protected $pageTemplate;

    /**
     * @var Response
     */
    protected $currentResponse;

    /**
     * PageController constructor.
     *
     * @param Application          $app
     * @param LoggerInterface      $logger
     * @param Translator           $translator
     * @param HTMLFactoryInterface $HTMLFactory
     * @param PageTemplate         $pageTemplate
     */
    public function __construct(Application $app, LoggerInterface $logger, Translator $translator, HTMLFactoryInterface $HTMLFactory, PageTemplate $pageTemplate)
    {
        parent::__construct($app, $logger, $translator, $HTMLFactory);
        $this->pageTemplate = $pageTemplate;
        $this->currentResponse = new Response();
    }

    /**
     * @param Response $response
     *
     * @return Response
     * @throws InvalidArgumentException
     * @throws \UnexpectedValueException
     */
    public function getPageResponse($response = null)
    {
        // Create response
        $response = $response ?: $this->getCurrentResponse();

        // Set response page content
        $response->setContent($this->getPageTemplate()->getHTML());

        // Finalize and send response
        return $this->finalizeResponse($response);
    }

    /**
     * @param string $title
     * @param string $viewName
     * @param string $id
     * @param string $class
     *
     * @return $this
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function build($title = '', $viewName = '', $id = '', $class = '')
    {
        // Build page skeleton
        $this->buildPageTemplate($title, $id, $class);

        // Build view
        parent::build($viewName);

        return $this;
    }

    /**
     * @param string $title
     * @param string $description
     * @param string $keywords
     *
     * @return $this
     * @throws Exception
     * @throws InvalidArgumentException
     */
    protected function buildPageTemplate($title = '', $description = '', $keywords = '')
    {
        // Create the page template
        $this->getPageTemplate()->build($title, $description, $keywords);
        $this->getApp()->set(HTMLDocument::class, $this->getPageTemplate());

        // Set skeleton html in body
        $this->viewContainer = $this->getPageTemplate()->getBody();

        return $this;
    }

    /**
     * @return PageTemplate
     */
    public function getPageTemplate(): PageTemplate
    {
        return $this->pageTemplate;
    }

    /**
     * @return Response
     */
    public function getCurrentResponse(): Response
    {
        return $this->currentResponse;
    }

    /**
     * @param Response $currentResponse
     *
     * @return $this
     */
    public function setCurrentResponse(Response $currentResponse)
    {
        $this->currentResponse = $currentResponse;

        return $this;
    }
}
