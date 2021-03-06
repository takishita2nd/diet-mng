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
Route::get('/eating/detail/{date}', 'Eating\EatingController@detail')->name('eating/detail');

Route::post('api/eating/add', 'Eating\ApiController@add');
Route::post('api/eating/update', 'Eating\ApiController@update');
Route::post('api/eating/delete', 'Eating\ApiController@delete');
Route::post('api/eating/list', 'Eating\ApiController@list');
Route::post('api/eating/detail', 'Eating\ApiController@detail');
Route::post('api/eating/graph', 'Eating\ApiController@graph');
Route::post('api/eating/settarget', 'Eating\ApiController@setTarget');

Route::get('/eating/maintenance', 'Eating\MaintenanceController@index')->name('maintenance');
Route::post('api/eating/history', 'Eating\ApiController@history');
Route::post('api/eating/regist', 'Eating\ApiController@regist');
Route::post('api/eating/search', 'Eating\ApiController@search');
