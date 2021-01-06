<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
    return response(['a' => ['a' => 'like']], 200);
});

$router->post('/hook', [
    'as' => 'hook', 'uses' => 'WebHookController@hook'
]);

$router->post('/send_request' ,['uses' => 'ChatBotController@sendText']);
