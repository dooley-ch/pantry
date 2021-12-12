<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductLookupController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'homePage'])->name('home');
Route::get('/setup', [HomeController::class, 'setupPage'])->name('setup');
Route::get('/usage', [HomeController::class, 'usagePage'])->name('usage');
Route::get('/about', [HomeController::class, 'aboutPage'])->name('about');

Route::get('/lookup', [ProductLookupController::class, 'homePage'])->name('lookup-homepage');
Route::post('/lookup', [ProductLookupController::class, 'lookup'])->name('lookup-search');

Route::group(['prefix' => '/api'], function () {
    Route::get('product/detail/{barcode}', [ApiController::class, 'getProductDetails'])->name('product-api-detail');
    Route::get('product/add/{barcode}', [ApiController::class, 'addProduct'])->name('product-api-add');
    Route::get('product/remove/{barcode}', [ApiController::class, 'removeProduct'])->name('product-api-add');
});

Route::group(['prefix' => '/product'], function () {
    Route::get('/', [ProductController::class, 'homePage'])->name('product-home');
    Route::get('detail/{barcode}', [ProductController::class, 'details'])->name('product-detail');
    Route::get('add/{barcode}', [ProductController::class, 'add'])->name('product-add');
    Route::get('remove/{barcode}', [ProductController::class, 'remove'])->name('product-remove');
    Route::get('delete/{barcode}', [ProductController::class, 'delete'])->name('product-delete');
});

Route::group(['prefix' => '/user'], function () {
    Route::get('/', [UserController::class, 'homePage'])->name('user-home');
});

Route::group(['prefix' => '/reports'], function () {
    Route::get('/', [ReportsController::class, 'homePage'])->name('reports-home');
});
