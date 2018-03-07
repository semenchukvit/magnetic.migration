<?php

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

Route::get('/', ['uses' => 'IndexController@show', 'as' => 'index']);

Route::get('/migrate', ['uses' => 'MigrateController@show', 'as' => 'migrate.show']);
Route::post('/migrate', ['uses' => 'MigrateController@store', 'as' => 'migrate.create']);

Route::get('/collections', ['uses' => 'CollectionController@show', 'as' => 'collections.show']);
Route::get('/collections/{id}', ['uses' => 'ProductController@show', 'as' => 'products.show']);
