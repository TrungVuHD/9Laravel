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

Route::auth();

Route::get('/', 'PostsController@index');
Route::get('/gag/{slug}', 'PostsController@show');
Route::get('/trending', 'PostsController@trendingIndex');
Route::get('/fresh', 'PostsController@freshIndex');
Route::get('/my-profile', 'PostsController@myProfileIndex');
Route::post('/upload-post', 'PostsController@store');

Route::group(['prefix' => '/settings', 'middleware' => 'auth'], function () {

	Route::get('/', 'SettingsController@showAccount');
	Route::get('/account', 'SettingsController@showAccount');
	Route::get('/password', 'SettingsController@showPassword');
	Route::get('/profile', 'SettingsController@showProfile');
});

Route::group(['prefix' => '/categories', 'middleware' => 'auth'], function () {

	Route::get('', 'CategoriesController@index');
	Route::get('/create', 'CategoriesController@create');
	Route::post('', 'CategoriesController@store');
	Route::get('/{category}/edit', 'CategoriesController@edit');
	Route::put('/{category}', 'CategoriesController@update');
	Route::delete('/{category}', 'CategoriesController@destroy');
});
Route::get('{category}', 'CategoriesController@show');