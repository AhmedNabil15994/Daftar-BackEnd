<?php

Route::group(['prefix' => 'shopping-cart'], function () {

  	Route::get('/' ,'FrontEnd\ShoppingCartController@index')
  	->name('frontend.shopping-cart.index');

    Route::get('delete/{id}' ,'FrontEnd\ShoppingCartController@delete')
  	->name('frontend.shopping-cart.delete');

    Route::get('clear' ,'FrontEnd\ShoppingCartController@clear')
  	->name('frontend.shopping-cart.clear');

    Route::get('header' ,'FrontEnd\ShoppingCartController@headerCart')
  	->name('frontend.shopping-cart.header');

    Route::get('total' ,'FrontEnd\ShoppingCartController@totalCart')
  	->name('frontend.shopping-cart.total');

    Route::post('{slug}' ,'FrontEnd\ShoppingCartController@createOrUpdate')
    ->name('frontend.shopping-cart.create-or-update');

});
