<?php


/*
|================================================================================
|                             Back-END ROUTES
|================================================================================
*/
Route::prefix('dashboard')->middleware(['dashboard.auth', 'permission:dashboard_access'])->group(function () {

    /*foreach (File::allFiles(module_path('PopupAdds', 'Routes/Dashboard')) as $file) {
        require_once($file->getPathname());
    }*/

    foreach (["popup_adds.php"] as $value) {
        require_once(module_path('PopupAdds', 'Routes/Dashboard/' . $value));
    }

});

/*
|================================================================================
|                             FRONT-END ROUTES
|================================================================================
*/
Route::prefix('/')->group(function () {

    /*foreach (File::allFiles(module_path('PopupAdds', 'Routes/FrontEnd')) as $file) {
        require_once($file->getPathname());
    }*/

    foreach (["routes.php"] as $value) {
        require_once(module_path('PopupAdds', 'Routes/FrontEnd/' . $value));
    }


});
