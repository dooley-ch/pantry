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

$router->get('/', 'HomeController@homePage');
$router->get('/usage', 'HomeController@usagePage');
$router->get('/about', 'HomeController@aboutPage');

$router->group(['prefix' => '/lookup/product'], function () use ($router) {
    $router->get('code/{code}', 'ProductLookupController@getProductByCode');
    $router->get('barcode/{barcode}', 'ProductLookupController@getProductByBarcode');
});

$router->group(['prefix' => '/api'], function () use ($router) {
    $router->get('product/detail/{barcode}', 'ApiController@getProductDetails');
    $router->get('product/add/{barcode}', 'ApiController@addProduct');
    $router->get('product/remove/{barcode}', 'ApiController@removeProduct');
});

$router->group(['prefix' => '/product'], function () use ($router) {
    $router->get('/', 'ProductController@homePage');
    $router->get('detail/{barcode}', 'ProductController@details');
    $router->get('add/{barcode}', 'ProductController@add');
    $router->get('remove/{barcode}', 'ProductController@remove');
    $router->get('delete/{barcode}', 'ProductController@delete');
});

$router->group(['prefix' => '/user'], function () use ($router) {
    $router->get('/', 'UserController@homePage');
});

$router->group(['prefix' => '/reports'], function () use ($router) {
    $router->get('/', 'ReportsController@homePage');
});
