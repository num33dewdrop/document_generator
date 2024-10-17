<?php

use Routes\Route;

Route::get('/', function() {
	view('auth.user-login');
})->name('user.login');

Route::get('/user-register', 'RegisterController@index')->name('user.register');

Route::get('/document-list', 'DocumentsController@list')->name('documents.list');

Route::handleRequest();