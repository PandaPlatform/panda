<?php

/*
 * This file is part of the Panda framework.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Bootstrap;

use Panda\Ui\Dom\Factories\DOMFactory;
use Panda\Ui\Dom\Factories\DOMFactoryInterface;
use Panda\Ui\Dom\Handlers\DOMHandler;
use Panda\Ui\Dom\Handlers\DOMHandlerInterface;
use Panda\Ui\Html\Factories\HTMLFactory;
use Panda\Ui\Html\Factories\HTMLFactoryInterface;
use Panda\Ui\Html\Factories\HTMLFormFactory;
use Panda\Ui\Html\Factories\HTMLFormFactoryInterface;
use Panda\Ui\Html\Handlers\HTMLHandler;
use Panda\Ui\Html\Handlers\HTMLHandlerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class HtmlEngine
 * @package App\Bootstrap
 */
class HtmlEngine extends AbstractBootLoader
{
    /**
     * @param Request $request
     */
    public function boot($request = null)
    {
        // Handlers
        $this->getApp()->set(DOMHandlerInterface::class, \DI\object(DOMHandler::class));
        $this->getApp()->set(HTMLHandlerInterface::class, \DI\object(HTMLHandler::class));

        // Factories
        $this->getApp()->set(DOMFactoryInterface::class, \DI\object(DOMFactory::class));
        $this->getApp()->set(HTMLFactoryInterface::class, \DI\object(HTMLFactory::class));
        $this->getApp()->set(HTMLFormFactoryInterface::class, \DI\object(HTMLFormFactory::class));
    }
}
