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
    return view('layouts.mainpage');
});

Route::get('/task', 'ProductController@index');

Route::post('/order/add', 'OrderController@add');

Route::post('/api', 'ApiController@index');

