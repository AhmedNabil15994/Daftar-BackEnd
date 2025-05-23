<?php

Route::get('categories/{slug}' ,'FrontEnd\CategoryController@show')
->name('frontend.categories.show');

Route::get('{vendor}/categories/{slug}' ,'FrontEnd\CategoryController@index')
->name('frontend.categories.index');
