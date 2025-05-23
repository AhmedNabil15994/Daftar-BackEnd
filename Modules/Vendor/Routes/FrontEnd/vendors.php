<?php

Route::group(['prefix' => 'vendors'], function () {

  	Route::get('{slug}' ,'FrontEnd\VendorController@index')
  	->name('frontend.vendors.index');

    Route::get('rating/{id}' ,'FrontEnd\VendorController@rating')
  	->name('frontend.vendors.rating');

    Route::post('rating/{id}' ,'FrontEnd\VendorController@saveRating')
  	->name('frontend.vendors.store.rating');

});
