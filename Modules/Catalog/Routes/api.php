<?php

Route::group(['prefix' => 'categories'], function () {

    Route::get('/', 'Api\CategoryController@list')->name('api.categories.list');
});


Route::group(['prefix' => 'brands'], function () {

    Route::get('/', 'Api\BrandController@list')->name('api.brands.list');
});

Route::group(['prefix' => 'products'], function () {
    Route::get('/', 'Api\ProductController@list')->name('api.products.list');
    Route::get('offers', 'Api\ProductController@offers')->name('api.products.offers');
    Route::get('new-arrival', 'Api\ProductController@newArrival')->name('api.products.arrival');
    Route::get('most-popular', 'Api\ProductController@mostPopular')->name('api.products.popular');
    Route::get('variation', 'Api\ProductController@variation')->name('api.products.variation');
    Route::get('{id}', 'Api\ProductController@show')->name('api.products.show');
    Route::post('cart/get-cart-products-qty', 'Api\ProductController@getCartProductsQty')->name('api.products.get_cart_products_qty');
});
