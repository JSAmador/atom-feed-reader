<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/feedReader', 'FeedsController@index');
$router->get('/feedReader/{id}', 'FeedsController@showEntry');
$router->get('/addFeed', function() {
    return view('AddFeed');
});

$router->post('/addFeed', 'FeedsController@store');

$router->post('/feedReader/{id}', 'FeedsController@storeRate');
