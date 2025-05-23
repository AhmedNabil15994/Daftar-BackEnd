<?php


/*
|================================================================================
|                             Back-END ROUTES
|================================================================================
*/
Route::prefix('dashboard')->middleware(['dashboard.auth', 'permission:dashboard_access'])->group(function () {

    /*foreach (File::allFiles(module_path('User', 'Routes/Dashboard')) as $file) {
        require_once($file->getPathname());
    }*/

    foreach (["admins.php", "drivers.php", "sellers.php", "users.php"] as $value) {
        require_once(module_path('User', 'Routes/Dashboard/' . $value));
    }

});


/*
|================================================================================
|                            VENDOR ROUTES
|================================================================================
*/
Route::prefix('vendor-dashboard')->middleware(['vendor.auth', 'permission:seller_access'])->group(function () {

    /*foreach (File::allFiles(module_path('User', 'Routes/Vendor')) as $file) {
        require_once($file->getPathname());
    }*/

    foreach (["users.php"] as $value) {
        require_once(module_path('User', 'Routes/Vendor/' . $value));
    }

});

/*
|================================================================================
|                             FRONT-END ROUTES
|================================================================================
*/
Route::prefix('/')->group(function () {

    /*foreach (File::allFiles(module_path('User', 'Routes/FrontEnd')) as $file) {
        require_once($file->getPathname());
    }*/

    foreach (["profile.php"] as $value) {
        require_once(module_path('User', 'Routes/FrontEnd/' . $value));
    }

});
