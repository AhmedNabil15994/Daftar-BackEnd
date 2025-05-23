<?php

Route::group(['prefix' => 'address'], function () {

  	Route::get('/' ,'FrontEnd\OrderAddressController@index')
  	->name('frontend.order.address.index')
    ->middleware('empty.cart');

    Route::post('user' ,'FrontEnd\OrderAddressController@userDeliveryCharge')
  	->name('frontend.order.address.user.delivery_charge')
    ->middleware('empty.cart');

    Route::post('guest' ,'FrontEnd\OrderAddressController@guestDeliveryCharge')
  	->name('frontend.order.address.guest.delivery_charge')
    ->middleware('empty.cart');
});
