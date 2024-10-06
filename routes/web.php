<?php
//ルートの記述
require_once '../app/Routes/Route.php';
require_once '../app/Controllers/DocumentsController.php';
use Routes\Route;
use Controllers\DocumentsController;

Route::get('/', function() {
	view('welcome');
});

Route::get('/document-list', [DocumentsController::class, 'index']);

Route::handleRequest();