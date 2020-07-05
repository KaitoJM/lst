<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/user', ['uses' => 'Admin\UserController@index', 'as' => 'user']);
    Route::get('/user-edit/{id}', ['uses' => 'Admin\UserController@edit', 'as' => 'user.edit']);
    Route::post('/update-user/{id}', ['uses' => 'Admin\UserController@updateUser', 'as' => 'user.update']);
});



Route::get('/', function () {
    return view('welcome');
});
