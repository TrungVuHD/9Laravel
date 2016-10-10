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
Route::get('/gag', 'PostsController@show');
Route::get('/trending', 'PostsController@trendingIndex');
Route::get('/fresh', 'PostsController@freshIndex');

Route::get('/settings', 'SettingsController@showAccount');
Route::get('/settings/account', 'SettingsController@showAccount');
Route::get('/settings/password', 'SettingsController@showPassword');
Route::get('/settings/profile', 'SettingsController@showProfile');
Route::get('/settings/my-profile', 'SettingsController@showMyProfile');

Route::get('/categories', 'CategoriesController@index');
Route::get('/categories/create', 'CategoriesController@create');
Route::post('/categories', 'CategoriesController@store');
Route::get('/categories/{category}/edit', 'CategoriesController@edit');
Route::put('/categories/{category}', 'CategoriesController@update');