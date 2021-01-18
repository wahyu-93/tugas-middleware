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

Route::namespace('login')->group(function(){
    Route::post('/auth/register', 'LoginController@register');
    Route::post('/auth/verification', 'LoginController@verification');
    Route::post('/auth/generate-otp', 'LoginController@generateOtp');
    Route::post('/auth/update-password', 'LoginController@updatePassword');
    Route::post('/auth/login', 'LoginController@login');

});

Route::namespace('profile')->middleware('auth:api')->group(function(){
    Route::get('profile/get-profile', 'ProfileController@getProfile');
    Route::post('profile/update-profile', 'ProfileController@updateProfile');

});
