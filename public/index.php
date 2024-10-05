<?php
//ルートで試す
require_once '../routes/web.php';

$uri = urldecode(
	parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

var_dump($uri);