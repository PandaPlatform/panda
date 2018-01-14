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

use App\Controllers\BaseController;
use Exception;
use InvalidArgumentException;
use Panda\Foundation\Application;
use Panda\Localization\Translator;
use Panda\Support\Facades\View;
use Panda\Ui\Dom\DOMBuilder;
use Panda\Ui\Html\Factories\HTMLFactory;
use Panda\Ui\Html\Factories\HTMLFactoryInterface;
use Panda\Ui\Html\HTMLElement;
use Psr\Log\LoggerInterface;

/**
 * Class ViewController
 * @package App\Controllers\Html
 */
abstract class AbstractViewController extends BaseController implements DOMBuilder
{
    /**
     * @var HTMLElement
     */
    protected $viewContainer;

    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var HTMLFactory
     */
    protected $HTMLFactory;

    /**
     * ViewController constructor.
     *
     * @param Application          $app
     * @param LoggerInterface      $logger
     * @param Translator           $translator
     * @param HTMLFactoryInterface $HTMLFactory
     */
    public function __construct(Application $app, LoggerInterface $logger, Translator $translator, HTMLFactoryInterface $HTMLFactory)
    {
        parent::__construct($app);
        $this->logger = $logger;
        $this->translator = $translator;
        $this->HTMLFactory = $HTMLFactory;
    }

    /**
     * @param string $viewName
     * @param string $id
     * @param string $class
     *
     * @return $this
     * @throws Exception
     */
    public function build($viewName = '', $id = '', $class = '')
    {
        // Create the View Container, if not any
        if (empty($this->getViewContainer())) {
            $viewElement = $this->getHTMLFactory()->buildHtmlElement('div', '', $id, $class);
            $this->setViewContainer($viewElement);
        }

        // Load view
        $this->loadView($viewName);

        return $this;
    }

    /**
     * @param string $viewName
     *
     * @return $this
     * @throws Exception
     */
    protected function loadView($viewName)
    {
        // Check if view name is empty
        if (empty($viewName)) {
            return $this;
        }

        // Load view html
        $viewHtml = $this->getViewHtml($viewName);

        // Get HTMLHandler and append view
        $this->getHTMLFactory()->getHTMLHandler()->innerHTML($this->getViewContainer(), $viewHtml);

        // Translate view
        $this->translate();

        return $this;
    }

    /**
     * @param string $viewName
     *
     * @return mixed
     * @throws InvalidArgumentException
     */
    protected function getViewHtml($viewName)
    {
        return View::load($viewName)->getOutput();
    }

    /**
     * Translate the current loaded view.
     *
     * @param HTMLElement $translationContainer
     *
     * @throws Exception
     * @throws InvalidArgumentException
     */
    protected function translate($translationContainer = null)
    {
        $HTMLHandler = $this->getHTMLFactory()->getHTMLHandler();

        // Get all translatable elements in the view
        $translationContainer = $translationContainer ?: $this->getViewContainer();
        $translatables = $translationContainer->select('[data-translate]');
        foreach ($translatables as $translatable) {
            // Get key
            $key = $HTMLHandler->attr($translatable, 'data-translate');

            // Get translation
            try {
                $translation = $this->getTranslator()->translate($key);

                // Add prefix according to environment
                $env = $this->getApp()->getEnvironment();
                $translation = ($env == 'development' ? '**' : '') . $translation;
            } catch (Exception $ex) {
                // Report to the logs that a translation is not found
                $this->getLogger()->error($ex->getMessage());

                // Keep the node value as translation
                $translation = $HTMLHandler->nodeValue($translatable);
            }

            // Apply translation
            $HTMLHandler->nodeValue($translatable, $translation);

            // Remove translation key attribute(s)
            $HTMLHandler->attr($translatable, 'data-translate', null);
            $HTMLHandler->attr($translatable, 'data-translate-comment', null);
        }
    }

    /**
     * Append an item to the view container.
     *
     * @param $item
     *
     * @throws InvalidArgumentException
     */
    public function appendToViewContainer($item)
    {
        $this->getViewContainer()->append($item);
    }

    /**
     * @return HTMLElement
     */
    public function getViewContainer()
    {
        return $this->viewContainer;
    }

    /**
     * @param HTMLElement $viewContainer
     *
     * @return AbstractViewController
     */
    public function setViewContainer(HTMLElement $viewContainer)
    {
        $this->viewContainer = $viewContainer;

        return $this;
    }

    /**
     * @return Translator
     */
    public function getTranslator(): Translator
    {
        return $this->translator;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    /**
     * @return HTMLFactory
     */
    public function getHTMLFactory(): HTMLFactory
    {
        return $this->HTMLFactory;
    }
}
