<?php

use Http\Routes\Route;

Route::get('/', function() {
	view('welcome');
})->name('welcome');

//ログイン済みユーザーがアクセスした場合にリダイレクトする。
//未認証ユーザーのアクセスを許可する。
Route::group(['middleware' => 'guest'], function() {
	//ログイン
	Route::get('/user/login', 'Auth\LoginController@index')->name('user-login.index');
	Route::post('/user/login', 'Auth\LoginController@login')->name('user-login.store');
	//登録
	Route::get('/user/register', 'Auth\RegisterController@index')->name('user-register.index');
	Route::post('/user/register', 'Auth\RegisterController@store')->name('user-register.store');
});

//未認証ユーザーがアクセスした場合にログインページへリダイレクトする。
//認証済みユーザーのアクセスを許可する。
Route::group(['middleware' => 'auth'], function() {
	//USER
	Route::get('/user/edit', 'UserController@edit')->name('user-edit.show');
	Route::put('/user/edit', 'UserController@update')->name('user-edit.store');
	Route::get('/user/logout', 'Auth\LoginController@logout')->name('user-logout.store');

	//DOCUMENT
	Route::get('/document', 'DocumentsController@list')->name('documents-list.show');
	Route::get('/document/register', 'DocumentsController@register')->name('documents-register.show');
	Route::get('/document/{id}/edit', 'DocumentsController@edit')->name('documents-edit.show');
	Route::get('/document/{id}/copy', 'DocumentsController@copy')->name('documents-copy.show');
	Route::post('/document', 'DocumentsController@create')->name('documents-register.store');
	Route::put('/document/{id}', 'DocumentsController@update')->name('documents-edit.store');
	Route::delete('/document/{id}', 'DocumentsController@delete')->name('documents-delete.store');

	//QUALIFICATION
	Route::get('/qualification', 'QualificationsController@list')->name('qualifications-list.show');
	Route::get('/qualification/register', 'QualificationsController@register')->name('qualifications-register.show');
	Route::get('/qualification/{id}/edit', 'QualificationsController@edit')->name('qualifications-edit.show');
	Route::post('/qualification', 'QualificationsController@create')->name('qualifications-register.store');
	Route::put('/qualification/{id}', 'QualificationsController@update')->name('qualifications-edit.store');
	Route::delete('/qualification/{id}', 'QualificationsController@delete')->name('qualifications-delete.store');

	//ACADEMIC BACKGROUND
	Route::get('/academic-background', 'AcademicBackgroundsController@list')->name('academic-backgrounds-list.show');
	Route::get('/academic-background/register', 'AcademicBackgroundsController@register')->name('academic-backgrounds-register.show');
	Route::get('/academic-background/{id}/edit', 'AcademicBackgroundsController@edit')->name('academic-backgrounds-edit.show');
	Route::post('/academic-background', 'AcademicBackgroundsController@create')->name('academic-backgrounds-register.store');
	Route::put('/academic-background/{id}', 'AcademicBackgroundsController@update')->name('academic-backgrounds-edit.store');
	Route::delete('/academic-background/{id}', 'AcademicBackgroundsController@delete')->name('academic-backgrounds-delete.store');

	//WORK EXPERIENCE
	Route::get('/work-experience', 'WorkExperiencesController@list')->name('work-experiences-list.show');
	Route::get('/work-experience/register', 'WorkExperiencesController@register')->name('work-experiences-register.show');
	Route::get('/work-experience/{id}/edit', 'WorkExperiencesController@edit')->name('work-experiences-edit.show');
	Route::post('/work-experience', 'WorkExperiencesController@create')->name('work-experiences-register.store');
	Route::put('/work-experience/{id}', 'WorkExperiencesController@update')->name('work-experiences-edit.store');
	Route::delete('/work-experience/{id}', 'WorkExperiencesController@delete')->name('work-experiences-delete.store');

	//DEPARTMENT
	Route::get('/work-experience/{w_id}/department', 'DepartmentsController@list')->name('departments-list.show');
	Route::get('/work-experience/{w_id}/department/register', 'DepartmentsController@register')->name('departments-register.show');
	Route::get('/work-experience/{w_id}/department/{d_id}/edit', 'DepartmentsController@edit')->name('departments-edit.show');
	Route::post('/work-experience/{w_id}/department', 'DepartmentsController@create')->name('departments-register.store');
	Route::put('/work-experience/{w_id}/department/{d_id}', 'DepartmentsController@update')->name('departments-edit.store');
	Route::delete('/work-experience/{w_id}/department/{d_id}', 'DepartmentsController@delete')->name('departments-delete.store');

	//OFFICIAL POSITION
	Route::get('/work-experience/{w_id}/official-position', 'OfficialPositionsController@list')->name('official-positions-list.show');
	Route::get('/work-experience/{w_id}/official-position/register', 'OfficialPositionsController@register')->name('official-positions-register.show');
	Route::get('/work-experience/{w_id}/official-position/{o_id}/edit', 'OfficialPositionsController@edit')->name('official-positions-edit.show');
	Route::post('/work-experience/{w_id}/official-position', 'OfficialPositionsController@create')->name('official-positions-register.store');
	Route::put('/work-experience/{w_id}/official-position/{o_id}', 'OfficialPositionsController@update')->name('official-positions-edit.store');
	Route::delete('/work-experience/{w_id}/official-position/{o_id}', 'OfficialPositionsController@delete')->name('official-positions-delete.store');
});