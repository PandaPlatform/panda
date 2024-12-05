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

use App\Support\Html\HTMLRender as EsatHTMLRender;
use DI\DependencyException;
use DI\NotFoundException;
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
use Panda\Ui\Html\Renders\FormRender;
use Panda\Ui\Html\Renders\HTMLRender;
use Panda\Ui\Html\Renders\RenderCollection;
use Panda\Ui\Html\Renders\RenderCollectionInterface;
use Panda\Ui\Html\Renders\SelectRender;

/**
 * Class HtmlEngine
 *
 * @package App\Bootstrap
 */
class HtmlEngine extends AbstractBootLoader
{
    /**
     * @param null $request
     *
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function boot($request = null)
    {
        // Handlers
        $this->getApp()->set(DOMHandlerInterface::class, \DI\get(DOMHandler::class));
        $this->getApp()->set(HTMLHandlerInterface::class, \DI\get(HTMLHandler::class));

        // Factories
        $this->getApp()->set(DOMFactoryInterface::class, \DI\get(DOMFactory::class));
        $this->getApp()->set(HTMLFactoryInterface::class, \DI\get(HTMLFactory::class));
        $this->getApp()->set(HTMLFormFactoryInterface::class, \DI\get(HTMLFormFactory::class));

        // Renders
        /** @var RenderCollection $renderCollection */
        $renderCollection = $this->getApp()->get(RenderCollection::class);
        $renderCollection->addRender($this->getApp()->get(HTMLRender::class));
        $renderCollection->addRender($this->getApp()->get(FormRender::class));
        $renderCollection->addRender($this->getApp()->get(SelectRender::class));
        $this->getApp()->set(RenderCollectionInterface::class, $renderCollection);
    }
}
