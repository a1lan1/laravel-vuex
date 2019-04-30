<?php

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/home', 'HomeController@index')->name('home');
});

Route::group(['middleware' => ['role:admin'], 'namespace' => 'Api'], function () {
    // users
    Route::get('/users', 'UserController@users')->name('api.users');
});
