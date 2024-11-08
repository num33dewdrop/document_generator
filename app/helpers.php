<?php

use Containers\Container;
use Http\Redirects\Redirect;
use Http\Routes\Route;
use Session\Session;
use Views\View;

if (!function_exists('app')) {
	function app($class): Container | null {
		try {
			return ( new Container() )->make( $class );
		} catch ( ReflectionException $e ) {
			error_log('create class failed : '. $e->getMessage());
			return null;
		}
	}
}

if (!function_exists('appendGetParam')) {
	function appendGetParam($get ,$arr_del_key = array(), $arr_in = array()): string {
		$str = '?';
		if( ! empty( $arr_in ) ) {
			foreach ( $arr_in as $key => $val ) {
				$str .= $key . '=' . $val . '&';
			}
		}
		if ( ! empty( $get ) ) {
			foreach ( $get as $key => $val ) {
				if ( ! in_array( $key, $arr_del_key, true ) ) {
					$str .= $key . '=' . $val . '&';
				}
			}
		}
		return  mb_substr( $str, 0, - 1, "UTF-8" );
	}
}

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

if (!function_exists('error')) {
	function error($key): array {
		return session()->get('errors', [])[$key]?? [];
	}
}

if (!function_exists('old')) {
	function old($key): string {
		return session()->get('old', [])[$key]?? '';
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

if (!function_exists('sanitize')) {
	function sanitize( $str ): string {
		return htmlspecialchars( $str, ENT_QUOTES );
	}
}

if (!function_exists('randomKey')) {
	function randomKey( $length = 8 ): string {
		$char = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		return substr( str_shuffle( str_repeat( $char, $length ) ), 0, $length );
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

		$output = '<ul class="c-error">';
		foreach ($errors as $error) {
			$output .= '<li class="c-error__item">' . htmlspecialchars($error) . '</li>';
		}
		$output .= '</ul>';

		return $output;
	}
}

if (!function_exists('redirect')) {
	function redirect(string $url = '', int $statusCode = 302, array $headers = []): Redirect
	{
		return new Redirect($url, $statusCode, $headers);
	}
}

if (!function_exists('session')) {
	function session(): Session
	{
		static $session = null;
		// 一度だけインスタンスを作成
		if ($session === null) {
			$session = new Session();
		}
		return $session;
	}
}