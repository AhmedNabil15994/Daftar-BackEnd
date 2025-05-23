<?php

Route::group(['prefix' => 'delivery-times', 'middleware' => ['api']], function () {

    Route::get('/', 'Api\DeliveryTimeController@list')->name('api.times.list');
    Route::get('custom-times', 'Api\DeliveryTimeController@getWeeklyDeliveryTimes')->name('api.times.custom.list');
});
