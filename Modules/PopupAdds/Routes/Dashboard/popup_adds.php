<?php

Route::group(['prefix' => 'popup-adds'], function () {

    Route::get('/', 'Dashboard\PopupAddsController@index')
        ->name('dashboard.popup_adds.index')
        ->middleware(['permission:show_popup_adds']);

    Route::get('datatable', 'Dashboard\PopupAddsController@datatable')
        ->name('dashboard.popup_adds.datatable')
        ->middleware(['permission:show_popup_adds']);

    Route::get('create', 'Dashboard\PopupAddsController@create')
        ->name('dashboard.popup_adds.create')
        ->middleware(['permission:add_popup_adds']);

    Route::post('/', 'Dashboard\PopupAddsController@store')
        ->name('dashboard.popup_adds.store')
        ->middleware(['permission:add_popup_adds']);

    Route::get('{id}/edit', 'Dashboard\PopupAddsController@edit')
        ->name('dashboard.popup_adds.edit')
        ->middleware(['permission:edit_popup_adds']);

    Route::put('{id}', 'Dashboard\PopupAddsController@update')
        ->name('dashboard.popup_adds.update')
        ->middleware(['permission:edit_popup_adds']);

    Route::delete('{id}', 'Dashboard\PopupAddsController@destroy')
        ->name('dashboard.popup_adds.destroy')
        ->middleware(['permission:delete_popup_adds']);

    Route::get('deletes', 'Dashboard\PopupAddsController@deletes')
        ->name('dashboard.popup_adds.deletes')
        ->middleware(['permission:delete_popup_adds']);

    Route::get('{id}', 'Dashboard\PopupAddsController@show')
        ->name('dashboard.popup_adds.show')
        ->middleware(['permission:show_popup_adds']);

});
