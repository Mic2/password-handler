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

// GETS
Route::get('/', 'PasswordController@Index');


// POSTS
Route::post('/store-password', 'PasswordController@StoreNewPassword');