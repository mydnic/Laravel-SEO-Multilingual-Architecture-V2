<?php

Route::get('/', 'PostController@index')->name('home');
Route::get(trans('routes.post') . '/{post}', 'PostController@show')->name('post.show');

Route::view(trans('routes.about'), 'about')->name('page.about');

Auth::routes();

Route::name('locale.switch')->get('switch/{locale}', 'LocaleController@switch');
