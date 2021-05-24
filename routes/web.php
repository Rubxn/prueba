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

Auth::routes();

Route::get('/{acc?}/{type?}/{id?}', 'MaestroController@index')->name('home');

Route::post('/marca', 'MaestroController@Marca')->middleware('auth');
Route::post('/producto', 'MaestroController@Producto')->middleware('auth');

