<?php

namespace App\Html;

use InvalidArgumentException;
use Panda\Foundation\Application;
use Panda\Http\Response;
use Panda\Ui\Html\HTMLPage;

/**
 * Class PageTemplate
 * @package App\Html
 */
class PageTemplate extends HTMLPage
{
    /**
     * @type Application
     */
    protected $app;

    /**
     * @param string $title
     * @param string $description
     * @param string $keywords
     *
     * @return $this
     * @throws InvalidArgumentException
     * @throws \Exception
     */
    public function build($title = '', $description = '', $keywords = '')
    {
        // Build page
        parent::build($title, $description, $keywords);

        // Add head resources
        $this->addHeadResources();

        // Set page ltr direction
        $this->setPageDirection('ltr');

        return $this;
    }

    /**
     * @param string $dir
     *
     * @throws InvalidArgumentException
     * @throws \Exception
     */
    public function setPageDirection($dir = 'ltr')
    {
        $html = $this->selectElement('html')->item(0);
        $this->getHTMLHandler()->attr($html, 'dir', $dir);
    }

    /**
     * Add page template head resources
     *
     * @throws InvalidArgumentException
     */
    private function addHeadResources()
    {
        // Set favicon
        $this->addIcon('/favicon.ico');

        // Add meta
        $this->addMeta('viewport', 'width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0');

        // Add font
        $this->addStyle('https://fonts.googleapis.com/css?family=Lato:100');

        // Add skeleton css
        $this->addStyle("/assets/panda/css/template.css");
    }

    /**
     * Get the HTML page in a response object.
     *
     * @param Response $response
     *
     * @return Response
     * @throws InvalidArgumentException
     * @throws \UnexpectedValueException
     */
    public function getResponseWithHtml($response = null)
    {
        // Get or create the response
        $response = ($response ?: new Response());

        // Get the page content
        $responseContent = $this->getHTML();

        // Set the response content
        $response->setContent($responseContent);

        // Send back the response
        return $response;
    }

    /**
     * @return Application
     */
    public function getApp()
    {
        return $this->app ?: Application::getInstance();
    }

    /**
     * @param Application $app
     */
    public function setApp($app)
    {
        $this->app = $app;
    }
}
