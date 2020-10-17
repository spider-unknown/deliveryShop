<?php

use Illuminate\Http\Request;
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
Route::post('/favorite', ['uses' => 'ProductApiController@favorite']);
Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['namespace' => 'Core'], function () {
        Route::get('/me', ['uses' => 'AuthController@me']);
    });


});
