<?php

Route::post('webhooks', 'Api\OrderController@webhooks')->name('api.orders.webhooks');

Route::group(['prefix' => 'orders'], function () {
    Route::post('create', 'Api\OrderController@createOrder')->name('api.orders.create');

    Route::get('success', 'Api\OrderController@success')->name('api.orders.success');
    Route::get('failed', 'Api\OrderController@failed')->name('api.orders.failed');
    Route::post('decrement-order/{id}', 'Api\OrderController@decrementOrderProductsQty')->name('api.orders.decrement_order');

    Route::group(['prefix' => '/','middleware' => 'auth:api'], function () {

        // Route::get('list', 'Api\OrderController@list')->name('api.orders.list');
        Route::get('list', 'Api\OrderController@userOrdersList')->name('api.orders.list');
    });
});
