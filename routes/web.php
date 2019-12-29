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

$router->group(['prefix'=>'api_detik/v1'], function() use($router){
    $router->get('/inventorys', 'InventoryController@index');
    $router->post('/inventory', 'InventoryController@create');
    $router->get('/inventory/{id}', 'InventoryController@show');
    $router->put('/inventory/{id}', 'InventoryController@update');
    $router->delete('/inventory/{id}', 'InventoryController@destroy');

    $router->post('/WaktuToText', 'InventoryController@timeToStr');
});