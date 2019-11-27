<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$router->group(['middleware' => 'cors'], function () use ($router) {
    $router->get('/players', 'PlayerController@playerLists');
    $router->get('/player/{id}', 'PlayerController@getPlayer')->where('id', '[0-9]+');
});