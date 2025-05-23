<?php

Route::group(['prefix' => 'login'], function () {

    if (env('LOGIN')):

        // Show Login Form
        Route::get('/', 'Dashboard\LoginController@showLogin')
        ->name('dashboard.login')
        ->middleware('guest');

        // Submit Login
        Route::post('/post', 'Dashboard\LoginController@postLogin')
        ->name('dashboard.login.post');

    endif;

});
