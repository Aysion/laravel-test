<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'login'], function () {
	Route::get('', 'LoginController@view')->name('.login');
	Route::post('', 'LoginController@authenticate');
	Route::get('logout', 'LoginController@logout');
});

Route::group(['middleware' => 'auth'], function () {

	Route::get('', 'HomeController@index')->name('.home');

	Route::group(['prefix' => 'user_type', 'name' => '.userType'], function () {
		Route::get('', 'UserTypeController@list');
		Route::get('form/{id?}', 'UserTypeController@form');
		Route::post('save', 'UserTypeController@save');
		Route::get('delete/{id}', 'UserTypeController@delete');
		Route::get('enable/{id}', 'UserTypeController@enable');
	});

	Route::group([ 'prefix' => 'user' ], function () {
		Route::get('', 'UserController@list');
		Route::get('form/{id?}', 'UserController@form')->name('.user.form');
		Route::post('save', 'UserController@save');
		Route::get('delete/{id}', 'UserController@delete');
		Route::get('enable/{id}', 'UserController@enable');
	});

});