<?php


Route::group(['prefix' => 'filemanager', 'middleware' => ['web', 'auth','admins.lfm']], function () {
     \UniSharp\LaravelFilemanager\Lfm::routes();
});
