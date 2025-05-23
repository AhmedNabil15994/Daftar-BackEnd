<?php

Route::get('filters/{categories?}' ,'FrontEnd\FilterController@filterWithCategory')
->name('frontend.categories.filters.show');


Route::get('{vendor}/filters' ,'FrontEnd\FilterController@index')
->name('frontend.filters.index');


Route::get('{vendor}/filters/{categories}' ,'FrontEnd\FilterController@categoriesFilter')
->name('frontend.categories.filters.index');
