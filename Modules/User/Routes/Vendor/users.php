<?php

Route::group(['prefix' => 'users'], function () {

  	Route::get('{id}/edit'	,'Vendor\UserController@edit')
  	->name('vendor.users.edit');

  	Route::put('{id}'		,'Vendor\UserController@update')
  	->name('vendor.users.update');

});
