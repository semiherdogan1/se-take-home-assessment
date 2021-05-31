<?php

use Illuminate\Support\Facades\Route;

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

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/products', 'ProductController');

    Route::get('/orders', 'OrderController@index');
    Route::post('/orders', 'OrderController@add');
    Route::delete('/orders', 'OrderController@remove');

    Route::get('/discounts', 'DiscountController');
});
