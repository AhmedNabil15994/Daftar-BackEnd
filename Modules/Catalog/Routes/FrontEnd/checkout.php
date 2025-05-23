<?php

Route::group(['prefix' => 'checkout'], function () {

  Route::get('/', 'FrontEnd\CheckoutController@index')
    ->name('frontend.checkout.index')
    ->middleware(['empty.cart', 'empty.address']);

  Route::post('/', 'FrontEnd\CheckoutController@createOrder')
    ->name('frontend.checkout.create_order')
    ->middleware(['empty.cart', 'empty.address']);

  Route::get('times', 'FrontEnd\CheckoutController@times')
    ->name('frontend.checkout.times');

  Route::get('custom-delivery-times', 'FrontEnd\CheckoutController@customDeliveryTimes')
    ->name('frontend.checkout.custom_delivery_times');
});
