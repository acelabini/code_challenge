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
    $router->group(['prefix' => 'players'], function () use ($router) {
        $router->get('/', 'PlayerController@playerLists');
        $router->get('/{id}', 'PlayerController@getPlayer')->where('id', '[0-9]+');
    });
});