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

use Exception;
use InvalidArgumentException;
use Monolog\Logger;
use Panda\Foundation\Application;
use Panda\Localization\Translator;
use Panda\Support\Facades\View;
use Panda\Ui\Contracts\Handlers\HTMLHandlerInterface;
use Panda\Ui\Html\HTMLElement;
use Psr\Log\LoggerInterface;

/**
 * Class ViewController
 * @package App\Controllers
 */
class ViewController extends BaseController
{
    /**
     * @var HTMLElement
     */
    protected $viewContainer;

    /**
     * @var Translator
     */
    private $translator;

    /**
     * @var LoggerInterface
     */
    private $logger;

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
     *
     * @return $this
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws \DI\NotFoundException
     */
    protected function loadView($viewName)
    {
        // Check if view name is empty
        if (empty($viewName)) {
            throw new InvalidArgumentException('The given view name is empty');
        }

        // Load view html
        $viewHtml = View::load($viewName)->getOutput();

        // Get HTMLHandler and append view
        /** @var HTMLHandlerInterface $HTMLHandler */
        $HTMLHandler = $this->getApp()->get(HTMLHandlerInterface::class);
        $HTMLHandler->innerHTML($this->getViewContainer(), $viewHtml);

        // Translate view
        $this->translate();

        return $this;
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
                $this->logger->log(Logger::ERROR, $ex->getMessage());

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
}
