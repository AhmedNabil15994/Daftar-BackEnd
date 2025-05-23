<?php

Route::group(['prefix' => 'sliders' ,'middleware' => ['api'] ], function () {

    Route::get('/' , 'Api\SliderController@list')->name('api.sliders.list');

});
