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
use Panda\Http\Response;
use Panda\Ui\Html\HTMLDocument;

/**
 * Class PageController
 * @package App\Controllers\Html
 */
abstract class PageController extends ViewController
{
    /**
     * @var PageTemplate
     */
    protected $page;

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
        $response = $response ?: new Response();

        // Set response page content
        $response->setContent($this->getPage()->getHTML());

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
     * @throws \DI\NotFoundException
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
     * @param string $id
     * @param string $class
     *
     * @return $this
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws \DI\NotFoundException
     */
    protected function buildPageTemplate($title, $id = '', $class = '')
    {
        // Create the page template
        /** @type PageTemplate $page */
        $this->page = $this->getApp()->make(PageTemplate::class);
        $this->page->build($title);
        $this->getApp()->set(HTMLDocument::class, $this->page);

        // Build view outer container
        $this->viewContainer = $this->page->create('div', '', $id, $class);
        $this->page->appendToBody($this->viewContainer);

        return $this;
    }

    /**
     * @return PageTemplate
     */
    public function getPage(): PageTemplate
    {
        return $this->page;
    }
}
