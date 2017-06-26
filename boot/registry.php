<?php

/*
 * This file is part of the Panda framework.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Panda\Foundation\Bootstrap\BootstrapRegistry;

// Get BootstrapRegistry
$app = \Panda\Foundation\Application::getInstance();

/** @var BootstrapRegistry $registry */
$registry = $app->make(BootstrapRegistry::class);
$registry->setItems([
    \App\Bootstrap\Configuration::class,
    \App\Bootstrap\Localization::class,
    \App\Bootstrap\HtmlEngine::class,
]);
