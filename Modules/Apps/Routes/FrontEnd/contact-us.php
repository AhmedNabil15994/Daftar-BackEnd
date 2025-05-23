<?php

Route::get('contact-us' , 'FrontEnd\HomeController@contactUs')->name('frontend.contact-us');
Route::post('contact-us' , 'FrontEnd\HomeController@sendContactUs')->name('frontend.send-contact-us');
