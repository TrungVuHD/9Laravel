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
Route::get('/trending', 'PostController@trendingIndex');
Route::get('/fresh', 'PostController@freshIndex');

Route::group(['prefix' => 'posts'], function () {
    Route::get('/search', 'PostController@searchIndex');
    Route::post('/', 'PostController@store');
    Route::get('/{slug}', 'PostController@show');
});

Route::group(['prefix' => '/my-profile'], function () {

    Route::get('/', 'MyProfileController@index');
    Route::get('/posts', 'MyProfileController@postsIndex');
    Route::get('/upvotes', 'MyProfileController@upvotesIndex');
    Route::get('/comments', 'MyProfileController@commentsIndex');
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

    Route::delete('/network/facebook', 'SettingController@destroyFacebook');
    Route::delete('/network/google', 'SettingController@destroyGoogle');
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

        Route::get('/fresh/{offset}/{limit}', 'PostController@retrieveFreshAjax');
        Route::get('/trending/{offset}/{limit}', 'PostController@retrieveTrendingAjax');
        Route::get('/hot/{offset}/{limit}', 'PostController@retrieveHotAjax');
        Route::get('/{category}/{start}', 'PostController@retrieveCategoryAjax');
        Route::post('/report', 'ReportController@store');
    });

    Route::get('search', 'PostController@search');
});

Route::post('/comments', 'CommentController@store');
//Route::get('{category}', 'CategoryController@show');

