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

    //Products
    Route::get('/products', ['uses' => 'ProductController@index', 'as' => 'product.index']);
    Route::get('/product/create', ['uses' => 'ProductController@create', 'as' => 'product.create']);
    Route::get('/product/edit', ['uses' => 'ProductController@edit', 'as' => 'product.edit']);
    Route::post('/product/store', ['uses' => 'ProductController@store', 'as' => 'product.store']);
    Route::post('/product/update', ['uses' => 'ProductController@update', 'as' => 'product.update']);
    Route::post('/product/delete', ['uses' => 'ProductController@delete', 'as' => 'product.delete']);
});
Route::group(['namespace' => 'Core', 'middleware' => 'auth'], function () {
    Route::get('/home', ['uses' => 'PageController@home', 'as' => 'home']);
    Route::get('/', ['uses' => 'PageController@home']);


});
