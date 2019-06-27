<?php

use Illuminate\Http\Request;

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('/user', 'AuthController@user');
    Route::get('/logout', 'AuthController@logout');
    Route::apiResource('todos', 'TodoController');
});

Route::group(['middleware' => 'throttle:30,1'], function() {
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('login', 'Auth\LoginController@login');
});
