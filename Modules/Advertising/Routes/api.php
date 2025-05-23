<?php

Route::group(['prefix' => 'ads', 'middleware' => ['api']], function () {

    Route::get('/', 'Api\AdvertisingController@list')->name('api.ads.list');
//    Route::get('get-random-advert', 'Api\AdvertisingController@getRandomAdvert')->name('api.ads.get_random_advert');

    Route::group(['prefix' => 'adverts-groups'], function () {
        Route::get('/', 'Api\AdvertisingController@getAdvertGroups')->name('api.ads.get_adverts-groups');
    });

});
