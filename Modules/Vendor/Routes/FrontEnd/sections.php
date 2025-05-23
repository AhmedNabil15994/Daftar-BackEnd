<?php

Route::group(['prefix' => 'sections'], function () {

  	Route::get('{slug}' ,'FrontEnd\SectionController@index')
  	->name('frontend.sections.index');

});
