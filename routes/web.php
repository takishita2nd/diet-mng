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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/weight', 'Weight\WeightController@index')->name('weight');

Route::post('api/weight/add', 'Weight\ApiController@add');
Route::post('api/weight/edit', 'Weight\ApiController@edit');
Route::post('api/weight/delete', 'Weight\ApiController@delete');
Route::post('api/weight/list', 'Weight\ApiController@list');
Route::post('api/weight/graph', 'Weight\ApiController@graph');
Route::post('api/weight/total', 'Weight\ApiController@total');

Route::get('/eating', 'Eating\EatingController@index')->name('eating');
