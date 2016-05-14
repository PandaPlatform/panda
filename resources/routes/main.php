<?php

//use \Panda\

/**
 * Handle the incoming requests using the route handler.
 */
Route::get("/", function() {
    return RouteResponse::runView("index");
});

?>