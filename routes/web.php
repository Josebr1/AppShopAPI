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

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group(['prefix' => 'user'], function () use ($app){
    $app->get('/', 'UserController@get');
    $app->get('/{id}', 'UserController@getById');
    $app->post('/', 'UserController@addUser');
    $app->put('/{id}', 'UserController@updateUser');
    $app->delete('/{id}', 'UserController@deleteUser');
});
