<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//
//Route::get('/', function () {
//    return view('welcome');
//});

use Illuminate\Support\Facades\Auth;


Route::post('login', 'UserController@login');
Route::post('register', 'UserController@registerUser');

Route::group(['prefix' => 'api', 'middleware' => ['api', 'auth:api']], function () {

    Route::post('/review', 'UserController@storeReview');
    Route::get('/allReview', 'UserController@showAllReview');
    Route::post('/replay', 'UserController@storeReplay');
    Route::get('/', function () {
        return Auth::guard('api')->user();
    });

});