<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return view('welcome');
});

// user registration
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// Login authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

/*Route::group(['middleware' => ['auth']], function () {
Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);
});*/

//added chapter 9.2

Route::get('/', 'MicropostsController@index');

// omit

    Route::group(['middleware' => 'auth'], function () {
        Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);
        Route::group(['prefix' => 'users/{id}'], function () {
        
        //フォロー機能
        Route::post('follow', 'UserFollowController@store')->name('user.follow');
        Route::delete('unfollow', 'UserFollowController@destroy')->name('user.unfollow');
        Route::get('followings', 'UsersController@followings')->name('users.followings');
        Route::get('followers', 'UsersController@followers')->name('users.followers');
        
        //お気に入り機能
        Route::post('do_favorite', 'PostFavoriteController@store')->name('user.do_favorite');
        Route::delete('undo_favorite', 'PostFavoriteController@destroy')->name('user.undo_favorite');
        Route::get('favorites', 'UsersController@favorites')->name('user.favorites');
        
    });

    Route::resource('microposts', 'MicropostsController', ['only' => ['store', 'destroy', 'update']]);
    
    Route::post('reply/{id}', 'MicropostsController@reply')->name('microposts.reply');
});