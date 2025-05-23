<?php

Route::group(['prefix' => 'times'], function () {

	Route::get('/', 'Dashboard\DeliveryTimeController@index')
		->name('dashboard.times.index')
		->middleware(['permission:show_times']);

	Route::put('update-custom-times', 'Dashboard\DeliveryTimeController@update')
		->name('dashboard.custom_times.update')
		->middleware(['permission:show_times']);

	/* Route::get('datatable'	,'Dashboard\DeliveryTimeController@datatable')
  	->name('dashboard.times.datatable')
  	->middleware(['permission:show_times']);

  	Route::get('create'		,'Dashboard\DeliveryTimeController@create')
  	->name('dashboard.times.create')
    ->middleware(['permission:add_times']);

  	Route::post('/'			,'Dashboard\DeliveryTimeController@store')
  	->name('dashboard.times.store')
    ->middleware(['permission:add_times']);

  	Route::get('{id}/edit'	,'Dashboard\DeliveryTimeController@edit')
  	->name('dashboard.times.edit')
    ->middleware(['permission:edit_times']);

  	Route::put('{id}'		,'Dashboard\DeliveryTimeController@update')
  	->name('dashboard.times.update')
    ->middleware(['permission:edit_times']);

  	Route::delete('{id}'	,'Dashboard\DeliveryTimeController@destroy')
  	->name('dashboard.times.destroy')
    ->middleware(['permission:delete_times']);

  	Route::get('deletes'	,'Dashboard\DeliveryTimeController@deletes')
  	->name('dashboard.times.deletes')
    ->middleware(['permission:delete_times']);

  	Route::get('{id}','Dashboard\DeliveryTimeController@show')
  	->name('dashboard.times.show')
    ->middleware(['permission:show_times']); */
});
