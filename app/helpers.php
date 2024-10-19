<?php

use Http\Redirects\Redirect;
use Http\Routes\Route;
use Views\View;

if (!function_exists('assets')) {
	function assets(string $path): string {
		return base_url() .'/assets/'. $path; // ベースURLを付加
	}
}

if (!function_exists('base_path')) {
	function base_path($path = ''): string {
		return rtrim(dirname(__DIR__), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR);
	}
}

// ベースURLを取得するヘルパー関数
if (!function_exists('base_url')) {
	function base_url(): string {
		return rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
	}
}

if (!function_exists('config')) {
	function config($key): string {
		$config = require base_path('config/app.php');
		return $config[$key];
	}
}

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

// ルートのURLを生成するヘルパー関数
if (!function_exists('route')) {
	function route(string $name): string {
		// 定義されたルートを取得
		$uri = Route::route($name);
		return base_url() . $uri; // ベースURLを付加
	}
}

if (!function_exists('view')) {
	function view($view, $data = []): void {
		View::render(str_replace('.', '/', $view), $data);
	}
}

if (!function_exists('view_parts')) {
	function view_parts($view, $data = []): void {
		View::include($view, $data);
	}
}


if (!function_exists('displayErrors')) {
	function displayErrors(array $errors): string {
		if (empty($errors)) {
			return '';
		}

		$output = '<div class="c-form__error">';
		foreach ($errors as $error) {
			$output .= '<p>' . htmlspecialchars($error) . '</p>';
		}
		$output .= '</div>';

		return $output;
	}
}

if (!function_exists('redirect')) {
	function redirect(string $url = '', int $statusCode = 302, array $headers = []): Redirect
	{
		return new Redirect($url, $statusCode, $headers);
	}
}

