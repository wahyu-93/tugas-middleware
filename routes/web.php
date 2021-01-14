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

Route::middleware('roleMiddleware')->group(function(){
    Route::get('/masuk-admin', 'adminController@tesMasukAdmin')->name('masuk.admin');
});

Route::middleware('verifEmailMiddlerware')->group(function(){
    Route::get('/verif-email', 'adminController@verifEmail')->name('verif.email');
});