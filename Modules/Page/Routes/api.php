<?php

Route::group(['prefix' => 'pages' ,'middleware' => ['api'] ], function () {

    Route::get('/' , 'Api\PageController@list')->name('api.pages.list');

});
