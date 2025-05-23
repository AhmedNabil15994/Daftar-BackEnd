<?php

Route::prefix('/')->group(function() {

    Route::get('/' , 'Vendor\VendorController@index')->name('vendor.home');

});
