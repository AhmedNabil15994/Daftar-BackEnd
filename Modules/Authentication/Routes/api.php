<?php

Route::group(['prefix' => 'auth'], function () {

    Route::post('login'             , 'Api\LoginController@postLogin')->name('api.auth.login');
    Route::post('register'          , 'Api\RegisterController@register')->name('api.auth.register');
    Route::post('forget-password'   , 'Api\ForgotPasswordController@forgetPassword')->name('api.auth.password.forget');

    Route::group(['prefix' => '/','middleware' => 'auth:api'], function () {

        Route::post('logout', 'Api\LoginController@logout')->name('api.auth.logout');

    });

});
