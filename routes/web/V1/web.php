<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Auth', 'verify' => true], function () {

    Route::get('/login', ['as' => 'login', 'uses' => 'LoginController@showLoginForm']);
    Route::post('/login', ['as' => 'login.post', 'uses' => 'LoginController@login']);
    Route::group(['middleware' => 'auth'], function () {
        Route::post('logout', ['as' => 'logout', 'uses' => 'LoginController@logout']);
    });
});
Route::get('/secure/config', ['uses' => 'ConfigController@configure']);
Route::get('/secure/config/migrate-refresh', ['uses' => 'ConfigController@migrateRefresh']);
Route::get('/secure/config/migrate', ['uses' => 'ConfigController@migrate']);
Route::get('/secure/config/db-seed', ['uses' => 'ConfigController@dbSeed']);
Route::get('/secure/config/clear-autoload', ['uses' => 'ConfigController@clearAutoLoad']);
Route::get('/secure/config/config-cache', ['uses' => 'ConfigController@configCache']);
Route::get('/secure/config/cache-clear', ['uses' => 'ConfigController@cacheClear']);
Route::get('/secure/config/key-generate', ['uses' => 'ConfigController@keyGenerate']);
Route::get('/secure/config/optimize', ['uses' => 'ConfigController@optimize']);

Route::group(['middleware' => 'auth'], function () {
    //Categories
    Route::get('/categories', ['uses' => 'CategoryController@index', 'as' => 'category.index']);
    Route::post('/category/store', ['uses' => 'CategoryController@store', 'as' => 'category.store']);
    Route::post('/category/update', ['uses' => 'CategoryController@update', 'as' => 'category.update']);
    Route::post('/category/delete', ['uses' => 'CategoryController@delete', 'as' => 'category.delete']);

    //City
    Route::get('/cities', ['uses' => 'CityController@index', 'as' => 'city.index']);
    Route::post('/city/store', ['uses' => 'CityController@store', 'as' => 'city.store']);
    Route::post('/city/update', ['uses' => 'CityController@update', 'as' => 'city.update']);

    //Countries
    Route::get('/countries', ['uses' => 'CountryController@index', 'as' => 'country.index']);
    Route::post('/country/store', ['uses' => 'CountryController@store', 'as' => 'country.store']);
    Route::post('/country/update', ['uses' => 'CountryController@update', 'as' => 'country.update']);

    //Products
    Route::get('/products', ['uses' => 'ProductController@index', 'as' => 'product.index']);
    Route::get('/product/create', ['uses' => 'ProductController@create', 'as' => 'product.create']);
    Route::get('/product/edit', ['uses' => 'ProductController@edit', 'as' => 'product.edit']);
    Route::post('/product/store', ['uses' => 'ProductController@store', 'as' => 'product.store']);
    Route::post('/product/update', ['uses' => 'ProductController@update', 'as' => 'product.update']);
    Route::post('/product/delete', ['uses' => 'ProductController@delete', 'as' => 'product.delete']);

    //Advertisement
    Route::get('/advertisements', ['uses' => 'AdvertisementController@index', 'as' => 'advertisement.index']);
    Route::get('/advertisement/create', ['uses' => 'AdvertisementController@create', 'as' => 'advertisement.create']);
    Route::get('/advertisement/edit', ['uses' => 'AdvertisementController@edit', 'as' => 'advertisement.edit']);
    Route::post('/advertisement/store', ['uses' => 'AdvertisementController@store', 'as' => 'advertisement.store']);
    Route::post('/advertisement/update', ['uses' => 'AdvertisementController@update', 'as' => 'advertisement.update']);
    Route::post('/advertisement/delete', ['uses' => 'AdvertisementController@delete', 'as' => 'advertisement.delete']);

    //Orders
    Route::get('/orders', ['uses' => 'OrderController@index', 'as' => 'order.index']);
    Route::get('/order', ['uses' => 'OrderController@show', 'as' => 'order.show']);
    Route::post('/order/accept', ['uses' => 'OrderController@accept', 'as' => 'order.accept']);
    Route::post('/order/delivered', ['uses' => 'OrderController@delivered', 'as' => 'order.delivered']);

});
Route::group(['namespace' => 'Core', 'middleware' => 'auth'], function () {
    Route::get('/home', ['uses' => 'PageController@home', 'as' => 'home']);
    Route::get('/', ['uses' => 'PageController@home']);


});
