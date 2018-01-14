<?php

namespace App\Views;

use Exception;
use InvalidArgumentException;
use Panda\Foundation\Application;
use Panda\Localization\Translator;
use Panda\Support\Facades\View;
use Panda\Ui\Dom\DOMBuilder;
use Panda\Ui\Html\Factories\HTMLFactoryInterface;
use Panda\Ui\Html\Handlers\HTMLHandlerInterface;
use Panda\Ui\Html\HTMLElement;
use Psr\Log\LoggerInterface;

/**
 * Class AbstractView
 * @package App\Views
 */
abstract class AbstractView implements DOMBuilder
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @var HTMLElement
     */
    protected $viewContainer = null;

    /**
     * @var HTMLFactoryInterface
     */
    protected $HTMLFactory;

    /**
     * AbstractView constructor.
     *
     * @param Application          $app
     * @param LoggerInterface      $logger
     * @param Translator           $translator
     * @param HTMLFactoryInterface $HTMLFactory
     */
    public function __construct(Application $app, LoggerInterface $logger, Translator $translator, HTMLFactoryInterface $HTMLFactory)
    {
        $this->app = $app;
        $this->logger = $logger;
        $this->translator = $translator;
        $this->HTMLFactory = $HTMLFactory;
    }

    /**
     * @param string $viewName
     * @param string $id
     * @param string $class
     * @param string $tagName
     *
     * @return $this
     * @throws Exception
     */
    public function build($viewName = '', $id = '', $class = '', $tagName = 'div')
    {
        // Create the View Container, if not any
        if (empty($this->getViewContainer())) {
            $viewElement = $this->getHTMLFactory()->buildHtmlElement($tagName, '', $id, $class);
            $this->setViewContainer($viewElement);
        }

        // Load view
        $this->loadView($viewName);

        // Translate content
        $this->translate();

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

        // Append view to view container
        $this->getHTMLHandler()->innerHTML($this->getViewContainer(), $viewHtml);

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
     * @throws Exception
     */
    protected function translate()
    {
        // Get all translatable elements in the view
        $translatables = $this->getViewContainer()->select('[data-translate]');
        foreach ($translatables as $translatable) {
            // Get key
            $key = $this->getHTMLHandler()->attr($translatable, 'data-translate');

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
                $translation = $this->getHTMLHandler()->nodeValue($translatable);
            }

            // Apply translation
            $this->getHTMLHandler()->nodeValue($translatable, $translation);

            // Remove translation key attribute(s)
            $this->getHTMLHandler()->attr($translatable, 'data-translate', null);
            $this->getHTMLHandler()->attr($translatable, 'data-translate-comment', null);
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
     * @return $this
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
     * @return Application
     */
    public function getApp(): Application
    {
        return $this->app;
    }

    /**
     * @return HTMLFactoryInterface
     */
    public function getHTMLFactory(): HTMLFactoryInterface
    {
        return $this->HTMLFactory;
    }

    /**
     * @return HTMLHandlerInterface
     */
    public function getHTMLHandler(): HTMLHandlerInterface
    {
        return $this->getHTMLFactory()->getHTMLHandler();
    }
}
