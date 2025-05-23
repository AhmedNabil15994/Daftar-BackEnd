<?php

Route::get('products/variations' ,'FrontEnd\ProductController@variations')
->name('frontend.products.variations');

Route::get('{vendor}/products/{slug}' ,'FrontEnd\ProductController@index')
->name('frontend.products.index');
