<?php

use Http\Routes\Route;

Route::get('/', function() {
	view('auth.user-login');
})->name('user-login.index');

Route::get('/user-register', 'Auth\RegisterController@index')->name('user-register.index');
Route::post('/user-register', 'Auth\RegisterController@store')->name('user-register.store');

Route::get('/document-list', 'DocumentsController@list')->name('documents.list');

Route::handleRequest();