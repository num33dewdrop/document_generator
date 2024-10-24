<?php

use Http\Routes\Route;

Route::get('/', function() {
	view('welcome');
})->name('user-login.index');

Route::get('/user-login', 'Auth\LoginController@index')->name('user-login.index');
Route::post('/user-login', 'Auth\LoginController@login')->name('user-login.store');
Route::get('/user-logout', 'Auth\LoginController@logout')->name('user-logout.store');

Route::get('/user-register', 'Auth\RegisterController@index')->name('user-register.index');
Route::post('/user-register', 'Auth\RegisterController@store')->name('user-register.store');

Route::get('/document-list', 'DocumentsController@list')->name('documents.list');

Route::handleRequest();