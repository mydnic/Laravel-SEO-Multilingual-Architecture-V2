<?php

Route::get('/', 'PostController@index');
Route::get(trans('routes.postkey') . '/{post}', 'PostController@show')->name('post.show');

Auth::routes();

Route::name('locale.switch')->get('switch/{locale}', 'LocaleController@switch');
