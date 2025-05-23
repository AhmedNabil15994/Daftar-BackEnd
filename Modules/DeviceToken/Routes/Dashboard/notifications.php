<?php

Route::group(['prefix' => 'notifications', 'namespace' => 'Dashboard'], function () {

    Route::get('/', 'DeviceTokenController@index')
        ->name('dashboard.notifications.index')
        ->middleware(['permission:show_notifications']);

    Route::post('/', 'DeviceTokenController@send')
        ->name('dashboard.notifications.send')
        ->middleware(['permission:show_notifications']);

});
