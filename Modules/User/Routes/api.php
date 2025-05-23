<?php

Route::group(['prefix' => 'user', 'middleware' => 'auth:api'], function () {
    Route::get('profile', 'Api\UserController@profile')->name('api.users.profile');
    Route::put('profile', 'Api\UserController@updateProfile')->name('api.users.profile');
    Route::put('change-password', 'Api\UserController@changePassword')->name('api.users.change.password');
    Route::delete('delete-account', 'Api\UserController@deleteUserAccount')->name('api.users.delete_account');
});

Route::group(['prefix' => 'address', 'middleware' => 'auth:api'], function () {
    Route::get('list', 'Api\AddressController@profile')->name('api.users.profile');
    Route::post('add', 'Api\AddressController@add')->name('api.users.add');
    Route::post('edit/{id}', 'Api\AddressController@edit')->name('api.users.edit');
    Route::post('delete/{id}', 'Api\AddressController@delete')->name('api.users.delete');
});
