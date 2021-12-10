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

$router->get('/', ['as' => 'home', 'uses' => 'HomeController@homePage']);
$router->get('/setup', ['as' => 'setup', 'uses' => 'HomeController@setupPage']);
$router->get('/usage', ['as' => 'usage', 'uses' => 'HomeController@usagePage']);
$router->get('/about', ['as' => 'about', 'uses' => 'HomeController@aboutPage']);

$router->get('/lookup', ['as' => 'lookup-homepage', 'uses' => 'ProductLookupController@homePage']);
$router->post('/lookup', ['as' => 'lookup-search', 'uses' => 'ProductLookupController@lookup']);

$router->group(['prefix' => '/api'], function () use ($router) {
    $router->get('product/detail/{barcode}', ['as' => 'product-api-detail', 'uses' => 'ApiController@getProductDetails']);
    $router->get('product/add/{barcode}', ['as' => 'product-api-add', 'uses' => 'ApiController@addProduct']);
    $router->get('product/remove/{barcode}', ['as' => 'product-api-add', 'uses' => 'ApiController@removeProduct']);
});

$router->group(['prefix' => '/product'], function () use ($router) {
    $router->get('/', ['as' => 'product-home', 'uses' => 'ProductController@homePage']);
    $router->get('detail/{barcode}', ['as' => 'product-detail', 'uses' => 'ProductController@details']);
    $router->get('add/{barcode}', ['as' => 'product-add', 'uses' => 'ProductController@add']);
    $router->get('remove/{barcode}', ['as' => 'product-remove', 'uses' => 'ProductController@remove']);
    $router->get('delete/{barcode}', ['as' => 'product-delete', 'uses' => 'ProductController@delete']);
});

$router->group(['prefix' => '/user'], function () use ($router) {
    $router->get('/', ['as' => 'user-home', 'uses' => 'UserController@homePage']);
});

$router->group(['prefix' => '/reports'], function () use ($router) {
    $router->get('/', ['as' => 'reports-home', 'uses' => 'ReportsController@homePage']);
});
