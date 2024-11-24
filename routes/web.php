<?php

use Http\Routes\Route;

Route::get('/', function() {
	view('welcome');
})->name('welcome');

//ログイン済みユーザーがアクセスした場合にリダイレクトする。
//未認証ユーザーのアクセスを許可する。
Route::group(['middleware' => 'guest'], function() {
	Route::get('/user/login', 'Auth\LoginController@index')->name('user-login.index');
	Route::post('/user/login', 'Auth\LoginController@login')->name('user-login.store');

	Route::get('/user/register', 'Auth\RegisterController@index')->name('user-register.index');
	Route::post('/user/register', 'Auth\RegisterController@store')->name('user-register.store');
});

//未認証ユーザーがアクセスした場合にログインページへリダイレクトする。
//認証済みユーザーのアクセスを許可する。
Route::group(['middleware' => 'auth'], function() {
	Route::get('/user/logout', 'Auth\LoginController@logout')->name('user-logout.store');

	Route::get('/document', 'DocumentsController@list')->name('documents-list.show');
	Route::get('/document/register', 'DocumentsController@register')->name('documents-register.show');
	Route::get('/document/{id}/edit', 'DocumentsController@edit')->name('documents-edit.show');
	Route::get('/document/{id}/copy', 'DocumentsController@copy')->name('documents-copy.show');

	Route::get('/qualification', 'QualificationsController@list')->name('qualifications-list.show');
	Route::get('/qualification/register', 'QualificationsController@register')->name('qualifications-register.show');
	Route::get('/qualification/{id}/edit', 'QualificationsController@edit')->name('qualifications-edit.show');

	Route::post('/qualification', 'QualificationsController@create')->name('qualifications-register.store');
	Route::put('/qualification/{id}', 'QualificationsController@update')->name('qualifications-edit.store');
	Route::delete('/qualification/{id}', 'QualificationsController@delete')->name('qualifications-delete.store');
});