<?php

Route::group(['prefix' => 'products'], function () {

  	Route::get('/' ,'Dashboard\ProductController@index')
  	->name('dashboard.products.index')
    ->middleware(['permission:show_products']);

    Route::get('reports' ,'Dashboard\ProductController@reports')
    ->name('dashboard.products.reports')
    ->middleware(['permission:show_products']);

  	Route::get('datatable'	,'Dashboard\ProductController@datatable')
  	->name('dashboard.products.datatable')
  	->middleware(['permission:show_products']);

  	Route::get('create'		,'Dashboard\ProductController@create')
  	->name('dashboard.products.create')
    ->middleware(['permission:add_products']);

  	Route::post('/'			,'Dashboard\ProductController@store')
  	->name('dashboard.products.store')
    ->middleware(['permission:add_products']);

  	Route::get('{id}/edit'	,'Dashboard\ProductController@edit')
  	->name('dashboard.products.edit')
    ->middleware(['permission:edit_products']);

  	Route::put('{id}'		,'Dashboard\ProductController@update')
  	->name('dashboard.products.update')
    ->middleware(['permission:edit_products']);

    Route::get('{id}/clone'	,'Dashboard\ProductController@clone')
  	->name('dashboard.products.clone')
    ->middleware(['permission:add_products']);

  	Route::delete('{id}'	,'Dashboard\ProductController@destroy')
  	->name('dashboard.products.destroy')
    ->middleware(['permission:delete_products']);

  	Route::get('deletes'	,'Dashboard\ProductController@deletes')
  	->name('dashboard.products.deletes')
    ->middleware(['permission:delete_products']);

  	Route::get('{id}','Dashboard\ProductController@show')
  	->name('dashboard.products.show')
    ->middleware(['permission:show_products']);

});
