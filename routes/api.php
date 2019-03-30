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

Route::group(['namespace' => 'User'], function () {

    Route::group(['middleware' => 'guest'], function () {
        Route::post('v1/user/register', 'RegisterController@register');
        Route::get('v1/user/activate/{code}', 'RegisterController@activateUser');
    });


});
