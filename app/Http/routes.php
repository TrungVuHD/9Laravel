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

Route::get('/facebook/redirect', 'SocialAuthController@facebookRedirect');
Route::get('/facebook/callback', 'SocialAuthController@facebookCallback');

Route::get('/google/redirect', 'SocialAuthController@googleRedirect');
Route::get('/google/callback', 'SocialAuthController@googleCallback');

Route::get('/', 'PostsController@index');
Route::get('/gag/{slug}', 'PostsController@show');
Route::get('/trending', 'PostsController@trendingIndex');
Route::get('/fresh', 'PostsController@freshIndex');
Route::get('/my-profile', 'PostsController@myProfileIndex');
Route::post('/upload-post', 'PostsController@store');
Route::get('search', 'PostsController@searchIndex');

Route::group(['prefix' => '/settings', 'middleware' => 'auth'], function () {

	Route::get('/', 'SettingsController@showAccount');
	Route::get('/account', 'SettingsController@showAccount');
	Route::get('/password', 'SettingsController@showPassword');
	Route::get('/profile', 'SettingsController@showProfile');
	Route::post('/account', 'SettingsController@storeAccount');
	Route::post('/password', 'SettingsController@storePassword');
	Route::post('/profile', 'SettingsController@storeProfile');
	Route::delete('/account', 'SettingsController@destroy');
});

Route::group(['prefix' => '/categories', 'middleware' => 'auth'], function () {

	Route::get('', 'CategoriesController@index');
	Route::get('/create', 'CategoriesController@create');
	Route::post('', 'CategoriesController@store');
	Route::get('/{category}/edit', 'CategoriesController@edit');
	Route::put('/{category}', 'CategoriesController@update');
	Route::delete('/{category}', 'CategoriesController@destroy');
});

Route::group(['prefix' => 'ajax'], function (){

	Route::group(['middleware' => 'auth'], function () {

		Route::post('points/increment', 'PointsController@incrementPoints');
		Route::post('points/decrement', 'PointsController@decrementPoints');
		Route::post('comments/increment', 'CommentsController@incrementPoints');
		Route::post('comments/decrement', 'CommentsController@decrementPoints');
	});

	Route::group(['prefix' => 'posts'], function () {

		Route::get('/fresh/{offset}/{limit}', 'PostsController@retrieveFreshAjax');
		Route::get('/trending/{offset}/{limit}', 'PostsController@retrieveTrendingAjax');
		Route::get('/hot/{offset}/{limit}', 'PostsController@retrieveHotAjax');
		Route::get('/{category}/{start}', 'PostsController@retrieveCategoryAjax');
	});

	Route::get('search', 'PostsController@search');

});

Route::post('/comments', 'CommentsController@store');
Route::get('{category}', 'CategoriesController@show');