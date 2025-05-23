<?php

Route::group(['prefix' => 'reports'], function () {

    Route::get('qty-products', 'Dashboard\ReportController@productsReports')->name('dashboard.qty-product.reports')->middleware(['permission:show_products']);

    Route::get('order-vendor', 'Dashboard\ReportController@ordersReports')->name('dashboard.order-vendor.reports')->middleware(['permission:show_orders']);

    Route::get('/', 'Dashboard\ReportController@reports')->name('dashboard.all_reports.index')->middleware(['permission:show_orders']);

    Route::group(['prefix' => 'product-sales'], function () {

        Route::get('/', 'Dashboard\ReportController@getProductsSalesReports')
            ->name('dashboard.reports.product_sale')
            ->middleware(['permission:show_orders']);
    
        Route::get('datatable', 'Dashboard\ReportController@productsSaleDataTable')
            ->name('dashboard.reports.product_sale_datatable')
            ->middleware(['permission:show_orders']);
    
    });

});
