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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('groups', 'App\Http\Controllers\GroupController');
Route::resource('users', 'App\Http\Controllers\UserController');

Route::post('edit', 'App\Http\Controllers\AjaxController@edit');
Route::post('usersList', 'App\Http\Controllers\AjaxController@usersList');
Route::post('assignusers', 'App\Http\Controllers\UserController@assignments');