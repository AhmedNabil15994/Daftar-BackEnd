<?php

Route::group(['prefix' => 'areas'], function () {

    Route::get('cities'  , 'Api\AreaController@cities')->name('api.areas.cities');

});
