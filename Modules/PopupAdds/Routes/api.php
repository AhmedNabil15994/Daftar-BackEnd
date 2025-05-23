<?php

Route::group(['prefix' => 'ads', 'middleware' => ['api']], function () {

    Route::get('/', 'Api\PopupAddsController@list')->name('api.popup_adds.list');
    Route::get('get-random-advert', 'Api\PopupAddsController@getRandomAdvert')->name('api.popup_adds.get_random_advert');

});
