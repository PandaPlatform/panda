<?php

/*
 * This file is part of the Panda framework.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Controllers\Pages\IndexController;
use Panda\Support\Facades\Route;

/**
 * Handle the incoming requests using the application router.
 */
Route::get('/', IndexController::class . '@index');
