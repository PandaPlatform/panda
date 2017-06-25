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
use Panda\Ui\Contracts\DOMBuilder;
use Panda\Ui\Contracts\Handlers\HTMLHandlerInterface;
use Panda\Ui\Html\HTMLElement;
use Psr\Log\LoggerInterface;

/**
 * Class ViewController
 * @package App\Controllers\Html
 */
abstract class ViewController extends BaseController implements DOMBuilder
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
     * ViewController constructor.
     *
     * @param Application     $app
     * @param LoggerInterface $logger
     * @param Translator      $translator
     */
    public function __construct(Application $app, LoggerInterface $logger, Translator $translator)
    {
        parent::__construct($app);
        $this->logger = $logger;
        $this->translator = $translator;
    }

    /**
     * @param string $viewName
     * @param string $id
     * @param string $class
     *
     * @return $this
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function build($viewName = '', $id = '', $class = '')
    {
        // Create the View Container, if not any
        if (empty($this->getViewContainer())) {
            /** @var HTMLElement $viewElement */
            $viewElement = $this->getApp()->make(HTMLElement::class, ['name' => 'div', 'value' => '', 'id' => $id, 'class' => $class]);
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
     * @throws \DI\NotFoundException
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
        /** @var HTMLHandlerInterface $HTMLHandler */
        $HTMLHandler = $this->getApp()->get(HTMLHandlerInterface::class);
        $HTMLHandler->innerHTML($this->getViewContainer(), $viewHtml);

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
     * @throws \DI\NotFoundException
     * @throws Exception
     */
    protected function translate()
    {
        /** @var HTMLHandlerInterface $HTMLHandler */
        $HTMLHandler = $this->getApp()->get(HTMLHandlerInterface::class);

        // Get all translatable elements in the view
        $translatables = $this->getViewContainer()->select('[data-translate]');
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

            // Remove translation key attribute
            $HTMLHandler->attr($translatable, 'data-translate', null);
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
    public function getViewContainer(): HTMLElement
    {
        return $this->viewContainer;
    }

    /**
     * @param HTMLElement $viewContainer
     *
     * @return ViewController
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
}
