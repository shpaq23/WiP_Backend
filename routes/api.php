<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => 'auth:api'], function(){
    ///passport authentication
    Route::get('user/logout', 'AuthController@logout');
    Route::get('user', 'UserController@user');
    Route::post('user/edit', 'UserController@edit');
    Route::get('user/setadmin/{uuid}', 'UserController@setAdmin')->middleware('admin');
    Route::get('user/activate/{uuid}', 'UserController@activate')->middleware('admin');
    Route::get('user/restore/{uuid}', 'UserController@restore')->middleware('admin');
    Route::get('user/delete/{uuid}', 'UserController@delete');

});

/// Authentication
Route::post('user/register', 'AuthController@register');
Route::post('user/login', 'AuthController@login')->name('login');
Route::get('user/reactivate/{email}', 'AuthController@reactivate');
Route::get('user/reset/{email}', 'AuthController@resetPasswordStep1');
Route::post('user/reset', 'AuthController@resetPasswordStep2');
Route::get('user/email/{email}', 'AuthController@email');