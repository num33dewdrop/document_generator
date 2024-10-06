<?php
require_once '../app/Views/View.php';
use Views\View;

if (!function_exists('env')) {
	function env($key, $default = null) {
		static $variables = null;
		if ($variables === null) {
			$variables = [];
			$envPath = base_path('.env');
			if (file_exists($envPath)) {
				$lines = file($envPath);
				foreach ($lines as $line) {
					if ( str_contains( $line, '=' ) ) {
						list($name, $value) = explode('=', trim($line), 2);
						$variables[$name] = $value;
					}
				}
			}
		}
		return $variables[ $key ] ?? $default;
	}
}

if (!function_exists('base_path')) {
	function base_path($path = ''): string {
		return rtrim(dirname(__DIR__), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR);
	}
}

if (!function_exists('view')) {
	function view($view, $data = []): void {
		View::render($view, $data);
	}
}
