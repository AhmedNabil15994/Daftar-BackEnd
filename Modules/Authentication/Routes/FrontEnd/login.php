<?php

Route::group(['prefix' => 'login'], function () {

    if (env('LOGIN')):

        // Show Login Form
        Route::get('/', 'FrontEnd\LoginController@showLogin')
        ->name('frontend.login')
        ->middleware('guest');

        // Submit Login
        Route::post('/', 'FrontEnd\LoginController@postLogin')
        ->name('frontend.login');

    endif;

});
