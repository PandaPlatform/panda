<?php

use \Panda\Support\Facades\Route;
use \Panda\Support\Facades\View;

/**
 * Handle the incoming requests using the application router.
 */
Route::get("/", function() {
    return View::load("index")->getOutput();
});