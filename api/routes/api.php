<?php

use Illuminate\Support\Facades\Route;

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

Route::group([ 'prefix' => 'auth' ], function () {
	Route::post('', 'AuthController@auth');
	Route::get('getOctKey', 'AuthController@getOctKey');
});

Route::group([ 'middleware' => 'JWTApi' ], function () {
	Route::get('', function() {
		return null;
	});

	Route::get('paginate/{keyModel}', 'Controller@paginate')->name('paginate');

	Route::apiResource('userType', 'UserTypeController');
	Route::patch('userType/{id}/restore', 'UserTypeController@restore')->name('userType.restore');

	Route::apiResource('user', 'UserController');
	Route::patch('user/{id}/restore', 'UserController@restore')->name('user.restore');

	Route::apiResource('configPage', 'ConfigPageController');
	Route::patch('configPage/{id}/restore', 'ConfigPageController@restore')->name('configPage.restore');

	Route::apiResource('configMenu', 'ConfigMenuController');

});
