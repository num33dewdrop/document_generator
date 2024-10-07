<?php
require_once '../app/Views/View.php';
require_once '../app/Routes/Route.php';
require_once '../app/Controllers/DocumentsController.php';

use Views\View;
use Routes\Route;
use Controllers\DocumentsController;

$config = require '../config/app.php';
View::setConfig($config);

Route::get('/', function() {
	view('welcome');
});

Route::get('/document-list', [DocumentsController::class, 'index']);

Route::handleRequest();