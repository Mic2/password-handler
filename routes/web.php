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
Route::view('/', 'welcome');

/*Route::get('/', function () {
    return view('welcome');
});*/

// POSTS
Route::post('/store-password', 'HomeController@StoreNewPassword');
Route::post('/get-password', 'HomeController@GetStoredPassword');
Route::post('/validate-two-factor', 'BarcodeController@ValidateTwoFactor');

Route::get('/barcode', 'BarcodeController@index');
Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();
