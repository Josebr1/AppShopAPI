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
    $app->post('/', 'UserController@insert');
    $app->put('/{id}', 'UserController@updateUser');
    $app->delete('/{id}', 'UserController@deleteUser');
});

$app->group(['prefix' => 'category'], function () use ($app){
    $app->get('/', 'CategoryController@get');
    $app->get('/{id}', 'CategoryController@getById');
    $app->get('/name/{name}', 'CategoryController@getByName');
    $app->get('/home/slide', 'CategoryController@getHomeSlide');
    $app->post('/', 'CategoryController@insert');
    $app->post('/update/{id}', 'CategoryController@update');
    $app->delete('/{id}', 'CategoryController@delete');
});

$app->group(['prefix' => 'product'], function () use ($app){
    $app->get('/', 'ProductController@get');
    $app->get('/{id}', 'ProductController@getById');
    $app->get('/category/{id}', 'ProductController@getByIdCategory');
    $app->get('/name/{name}', 'ProductController@getByName');
    $app->get('/home/products', 'ProductController@getHomeProducts');
    $app->post('/', 'ProductController@insert');
    $app->post('/update/{id}', 'ProductController@update');
    $app->delete('/{id}', 'ProductController@delete');
});

$app->group(['prefix' => 'commentary'], function () use ($app){
    $app->get('/', 'CommentaryController@get');
    $app->get('/product/{id}', 'CommentaryController@getByProduct');
    $app->get('/{id}', 'CommentaryController@getById');
    $app->post('/', 'CommentaryController@insert');
    $app->put('/{id}', 'CommentaryController@update');
    $app->delete('/{id}', 'CommentaryController@delete');
});

$app->group(['prefix' => 'order'], function () use ($app){
    $app->get('/', 'OrderController@get');
    $app->get('/{id}', 'OrderController@getById');
    $app->get('/products/{id}', 'OrderController@getAllProducts');
    $app->get('/orders/form/payment/{id}', 'OrderController@getAllUsersFormPayment');

    $app->get('/orders/status/placed', 'OrderController@getAllOrderPlaced');
    $app->get('/orders/status/canceled', 'OrderController@getAllCanceledRequest');
    $app->get('/orders/status/delivery', 'OrderController@getAllOrderLeftForDelivery');
    $app->get('/orders/status/completed', 'OrderController@getAllOrderCompleted');

    $app->get('/orders/status/{id}', 'OrderController@getAllSales');
    $app->get('/user/top/sales', 'OrderController@getUserTopSales');
    $app->get('/sale/month', 'OrderController@getAllMonth');
    $app->get('/sale/day', 'OrderController@getAllDay');
    $app->get('/products/orders/{id}', 'OrderController@getAllProductsOrder');
    $app->post('/', 'OrderController@insert');
    $app->post('/status/{id}', 'OrderController@updateStatus');
    $app->put('/address/{id}', 'OrderController@updateAddress');
    $app->delete('/{id}', 'OrderController@delete');
});

$app->group(['prefix' => 'payment'], function () use ($app){
    $app->post('/', 'PagarMeController@index');
});