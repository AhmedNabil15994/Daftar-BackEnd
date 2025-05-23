<?php

Route::group(['prefix' => 'orders'], function () {

	Route::get('success', 'Dashboard\OrderController@success')
		->name('dashboard.orders.success')
		->middleware(['permission:show_orders']);

	Route::get('/', 'Dashboard\OrderController@index')
		->name('dashboard.orders.index')
		->middleware(['permission:show_orders']);

	Route::get('datatable', 'Dashboard\OrderController@datatable')
		->name('dashboard.orders.datatable')
		->middleware(['permission:show_orders']);

	Route::get('success-datatable', 'Dashboard\OrderController@successDatatable')
		->name('dashboard.orders.success.datatable')
		->middleware(['permission:show_orders']);

	Route::get('create', 'Dashboard\OrderController@create')
		->name('dashboard.orders.create')
		->middleware(['permission:add_orders']);

	Route::post('/', 'Dashboard\OrderController@store')
		->name('dashboard.orders.store')
		->middleware(['permission:add_orders']);

	Route::get('{id}/edit', 'Dashboard\OrderController@edit')
		->name('dashboard.orders.edit')
		->middleware(['permission:edit_orders']);

	Route::put('{id}', 'Dashboard\OrderController@update')
		->name('dashboard.orders.update')
		->middleware(['permission:edit_orders']);

	Route::get('bulk/update-delivery-status', 'Dashboard\OrderController@updateBulkDeliveryStatus')
		->name('dashboard.orders.update_bulk_delivery_status')
		->middleware(['permission:edit_delivery_status']);

	Route::delete('{id}', 'Dashboard\OrderController@destroy')
		->name('dashboard.orders.destroy')
		->middleware(['permission:delete_orders']);

	Route::get('deletes', 'Dashboard\OrderController@deletes')
		->name('dashboard.orders.deletes')
		->middleware(['permission:delete_orders']);

	Route::get('{id}', 'Dashboard\OrderController@show')
		->name('dashboard.orders.show')
		->middleware(['permission:show_orders']);

	Route::get('print/selected-items', 'Dashboard\OrderController@printSelectedItems')
		->name('dashboard.orders.print_selected_items')
		->middleware(['permission:show_orders']);
});
