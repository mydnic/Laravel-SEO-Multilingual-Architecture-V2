<?php

Route::get('/', 'PostController@index');
Route::get('post/{post}', 'PostController@show')->name('post.show');

Auth::routes();
