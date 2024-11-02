<?php

use Http\Routes\Route;

Route::get('/', function() {
	view('welcome');
})->name('welcome');

Route::group(['middleware' => 'guest'], function() {
	Route::get('/user-login', 'Auth\LoginController@index')->name('user-login.index');
	Route::post('/user-login', 'Auth\LoginController@login')->name('user-login.store');

	Route::get('/user-register', 'Auth\RegisterController@index')->name('user-register.index');
	Route::post('/user-register', 'Auth\RegisterController@store')->name('user-register.store');
});


Route::group(['middleware' => 'auth'], function() {
	Route::get('/user-logout', 'Auth\LoginController@logout')->name('user-logout.store');

	Route::get('/document-list', 'DocumentsController@list')->name('documents-list.show');
	Route::get('/document-register', 'DocumentsController@register')->name('documents-register.show');
	Route::get('/document-edit', 'DocumentsController@edit')->name('documents-edit.show');
	Route::get('/document-copy', 'DocumentsController@copy')->name('documents-copy.show');

	Route::get('/qualification-list', 'QualificationsController@list')->name('qualifications-list.show');
	Route::get('/qualification-register', 'QualificationsController@register')->name('qualifications-register.show');
	Route::get('/qualification-edit', 'QualificationsController@edit')->name('qualifications-edit.show');
	Route::post('/qualification-register', 'QualificationsController@create')->name('qualifications-register.store');
	Route::post('/qualification-edit', 'QualificationsController@update')->name('qualifications-edit.store');
	Route::post('/qualification-delete', 'QualificationsController@delete')->name('qualifications-delete.store');

});