<?php

Route::group(['prefix' => 'favorites'], function () {

  	Route::get('/' ,'FrontEnd\FavoriteController@index')
  	->name('frontend.favorites.index');

    Route::get('delete/{id}' ,'FrontEnd\FavoriteController@delete')
  	->name('frontend.favorites.delete');

    Route::get('clear' ,'FrontEnd\FavoriteController@clear')
  	->name('frontend.favorites.clear');

    Route::get('{slug}' ,'FrontEnd\FavoriteController@add')
    ->name('frontend.favorites.add');

});
