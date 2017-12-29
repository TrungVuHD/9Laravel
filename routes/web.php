<?php

Auth::routes();

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
});

Route::get('/facebook/redirect', 'SocialAuthController@facebookRedirect');
Route::get('/facebook/callback', 'SocialAuthController@facebookCallback');

Route::get('/google/redirect', 'SocialAuthController@googleRedirect');
Route::get('/google/callback', 'SocialAuthController@googleCallback');


Route::get('/', 'PostController@index');
Route::get('/trending', 'PostController@trending');
Route::get('/fresh', 'PostController@fresh');

Route::group(['prefix' => 'posts'], function () {
    Route::get('/search', 'PostController@searchIndex');
    Route::post('/', 'PostController@store');
    Route::get('/{slug}', 'PostController@show');
});

Route::group(['prefix' => '/my-profile', 'middleware' => 'auth'], function () {
    Route::get('/', 'ProfileController@index');
    Route::get('/posts', 'ProfileController@postsIndex');
    Route::get('/upvotes', 'ProfileController@upvotesIndex');
    Route::get('/comments', 'ProfileController@commentsIndex');
});

Route::group(['prefix' => '/settings', 'middleware' => 'auth'], function () {
    Route::get('/', 'SettingController@showAccount');
    Route::get('/account', 'SettingController@showAccount');
    Route::get('/password', 'SettingController@showPassword');
    Route::get('/profile', 'SettingController@showProfile');
    Route::post('/account', 'SettingController@storeAccount');
    Route::post('/password', 'SettingController@storePassword');
    Route::post('/profile', 'SettingController@storeProfile');
    Route::delete('/account', 'SettingController@destroy');
    Route::delete('/network/facebook', 'SocialAuthController@disconnectFacebook');
    Route::delete('/network/google', 'SocialAuthController@disconnectGoogle');
});

/*
Route::group(['prefix' => '/categories', 'middleware' => 'auth'], function () {

    Route::get('', 'CategoryController@index');
    Route::get('/create', 'CategoryController@create');
    Route::post('', 'CategoryController@store');
    Route::get('/{category}/edit', 'CategoryController@edit');
    Route::put('/{category}', 'CategoryController@update');
    Route::delete('/{category}', 'CategoryController@destroy');
});*/

Route::group(['prefix' => 'ajax'], function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::post('points/increment', 'PointController@incrementPoints');
        Route::post('points/decrement', 'PointController@decrementPoints');
        Route::post('comments/increment', 'CommentController@incrementPoints');
        Route::post('comments/decrement', 'CommentController@decrementPoints');
    });

    Route::group(['prefix' => 'posts'], function () {
        Route::get('/fresh', 'Ajax\PostController@fresh');
        Route::get('/trending', 'Ajax\PostController@trending');
        Route::get('/hot', 'Ajax\PostController@hot');
        Route::get('/categories/{id}', 'PostController@retrieveCategoryAjax');
        Route::post('/report', 'ReportController@store');
    });

    Route::get('search', 'PostController@search');
});

Route::group(['prefix' => 'comments'], function () {
    Route::post('/', 'CommentController@store')->middleware('auth');
});
//Route::get('{category}', 'CategoryController@show');

