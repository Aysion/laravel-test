<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'login'], function () {
	Route::get('', 'LoginController@view')->name('.login');
	Route::post('', 'LoginController@authenticate');
	Route::get('logout', 'LoginController@logout');
});

Route::group(['middleware' => 'auth'], function () {

	Route::get('', 'HomeController@index')->name('.home');

	Route::group(['prefix' => 'users_type', 'name' => '.userType'], function () {
		Route::get('', 'UsersTypeController@list');
		Route::get('form/{id?}', 'UsersTypeController@form');
		Route::post('save', 'UsersTypeController@save');
		Route::get('delete/{id}', 'UsersTypeController@delete');
		Route::get('enable/{id}', 'UsersTypeController@enable');
	});

	Route::group([ 'prefix' => 'user' ], function () {
		Route::get('', 'UserController@list');
		Route::get('form/{id?}', 'UserController@form')->name('.user.form');
		Route::post('save', 'UserController@save');
		Route::get('delete/{id}', 'UserController@delete');
		Route::get('enable/{id}', 'UserController@enable');
	});

});