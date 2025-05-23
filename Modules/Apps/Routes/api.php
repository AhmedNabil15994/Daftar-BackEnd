<?php

Route::group(['prefix' => 'contact-us'], function () {
    Route::post('/', 'Api\ContactUsController@send')->name('api.contact-us.send');
});
