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
//Route::get('test', 'UserController@test');

Route::get('user/activate/{token}', 'AuthController@activate');
//Route::get('test', 'UserController@test');