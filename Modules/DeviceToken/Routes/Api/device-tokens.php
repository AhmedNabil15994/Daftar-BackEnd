<?php

Route::group(['prefix' => 'device-tokens', 'namespace' => 'Api'], function () {

    Route::post('/', 'DeviceTokenController@create');

});
