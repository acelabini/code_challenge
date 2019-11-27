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
    $router->get('/bootstrap-static', function () {
        return response(file_get_contents(public_path('players.wsdl')), 200, [
            'Content-Type' => 'application/xml'
        ]);
    });
});