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

Route::group(['namespace' => 'Core'], function () {
    Route::post('/login', ['uses' => 'AuthController@login']);
    Route::post('/register', ['uses' => 'AuthController@register']);
    Route::post('/send/code', ['uses' => 'AuthController@sendCode']);
    Route::post('/change/password', ['uses' => 'AuthController@changePassword']);

});
Route::get('/categories', ['uses' => 'ProductApiController@categories']);
Route::get('/advertisements', ['uses' => 'CommonApiController@advertisements']);
Route::get('/cities', ['uses' => 'CommonApiController@cities']);
Route::get('/products', ['uses' => 'ProductApiController@products']);

//KKB pay
Route::get('/order/pay', ['uses' => 'OrderApiController@orderPay']);
Route::post('/order/payment/process', ['uses' => 'OrderApiController@kkbOrderProcess']);
Route::get('/order/payment/success', ['uses' => 'OrderApiController@kkbSuccess']);
Route::get('/order/payment/failure', ['uses' => 'OrderApiController@kkbFailure']);
Route::get('/order/payment/status', ['uses' => 'OrderApiController@kkbOrderStatus']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['namespace' => 'Core'], function () {
        Route::get('/me', ['uses' => 'AuthController@me']);

    });
    Route::post('/favorite', ['uses' => 'ProductApiController@favorite']);

    //Profile
    Route::get('/profile', ['uses' => 'ProfileApiController@profile']);
    Route::get('/profile/addresses', ['uses' => 'ProfileApiController@addresses']);
    Route::post('/profile/address', ['uses' => 'ProfileApiController@addOrEditAddress']);
    Route::post('/profile/update', ['uses' => 'ProfileApiController@profileUpdate']);
    Route::post('/password/update', ['uses' => 'ProfileApiController@passwordUpdate']);
    Route::post('/profile/avatar', ['uses' => 'ProfileApiController@avatarChange']);

    //Order
    Route::get('/orders', ['uses' => 'OrderApiController@orders']);
    Route::post('/make/order', ['uses' => 'OrderApiController@makeOrder']);



});
