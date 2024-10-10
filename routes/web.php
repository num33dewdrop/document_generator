<?php
use Routes\Route;
use Controllers\DocumentsController;

Route::get('/', function() {
	view('welcome');
});

Route::get('/document-list', [DocumentsController::class, 'index']);

Route::handleRequest();