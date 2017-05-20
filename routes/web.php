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

$app->group(['prefix' => 'category'], function () use ($app){
    $app->get('/', 'CategoryController@get');
    $app->get('/{id}', 'CategoryController@getById');
    $app->get('/name/{name}', 'CategoryController@getByName');
    $app->post('/', 'CategoryController@insert');
    $app->put('/{id}', 'CategoryController@update');
    $app->delete('/{id}', 'CategoryController@delete');
});

$app->group(['prefix' => 'product'], function () use ($app){
    $app->get('/', 'ProductController@get');
    $app->get('/{id}', 'ProductController@getById');
    $app->get('/category/{id}', 'ProductController@getByIdCategory');
    $app->get('/name/{name}', 'ProductController@getByName');
    $app->post('/', 'ProductController@insert');
    $app->put('/{id}', 'ProductController@update');
    $app->delete('/{id}', 'ProductController@delete');
});