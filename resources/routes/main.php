<?php

use App\Controllers\IndexController;
use Panda\Support\Facades\Route;

/**
 * Handle the incoming requests using the application router.
 */
Route::get("/", IndexController::class . '@index');
