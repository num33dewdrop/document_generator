<?php

use App\Containers\Container;
use App\Http\Redirects\Redirect;
use App\Http\Responses\Response;
use App\Http\Routes\Route;
use App\Session\Session;
use App\Views\View;

if (!function_exists('app')) {
	/**
	 * @throws ReflectionException
	 */
	function app($class = '') {
		if($class === '') {
			return new Container();
		}
		try {
			return ( new Container() )->make( $class );
		} catch ( ReflectionException $e ) {
			throw new ReflectionException("クラスのインスタンス化に失敗しました: " . $e->getMessage(), 500);
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

//
if (!function_exists('base_domain')) {
	function base_domain(): string {
		return (empty($_SERVER['HTTPS']) ? 'http://' : 'https://').$_SERVER['HTTP_HOST'];
	}
}

if (!function_exists('config')) {
	function config($key): string {
		$config = require base_path('config/app.php');
		return $config[$key];
	}
}

if (!function_exists('token')) {
	function token(int $length = 32): string {
		try {
			// 指定された長さのランダムバイトを生成し、16進数に変換
			return bin2hex(random_bytes($length));
		} catch (Exception $e) {
			// ログを記録（必要に応じてエラー詳細を保存）
			error_log('トークンの生成に失敗しました: ' . $e->getMessage());
			// カスタム例外をスロー
			throw new RuntimeException('トークンの生成に失敗しました。再試行してください。', 500);
		}
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
	function error(string $key, array $default = []): array {
		return session()->get('errors', $default)[$key]?? [];
	}
}

if (!function_exists('formatDateWithAge')) {
	function formatDateWithAge(string $birthdate): string {
		// 入力された日付を DateTime オブジェクトに変換
		try {
			$birthDate = new DateTime( $birthdate );
			$today = new DateTime(); // 現在の日付

			// 年月日部分をフォーマット
			$formattedDate = $birthDate->format('Y年m月d日');

			// 年齢を計算（満年齢）
			$age = $today->diff($birthDate)->y;

			// フォーマットされた文字列を返す
			return "{$formattedDate}　（満　{$age}歳）";
		} catch ( Exception $e ) {
			error_log("日付のフォーマットに失敗しました : $e");
			return "年　　月　　日　（満　　歳）";
		}
	}
}

if (!function_exists('old')) {
	function old(string $key, array $default = []): string {
		return session()->get('old', $default)[$key]?? '';
	}
}

if (!function_exists('oldArray')) {
	function oldArray(string $key, array $default = []): array {
		return session()->get('old', $default)[$key]?? [];
	}
}

// ルートのURLを生成するヘルパー関数
if (!function_exists('route')) {
	function route(string $name, array $params = []): string {
		// 定義されたルートを取得
		$uri = Route::route($name);
		// パラメータを置換
		foreach ($params as $key => $value) {
			$uri = str_replace('{' . $key . '}', $value, $uri);
		}
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
	function view($view, $data = [], $type = ""): void {
		View::render(str_replace('.', '/', $view), $data, $type);
	}
}

if (!function_exists('view_parts')) {
	function view_parts($view, $parts_data = []): void {
		View::include($view, $parts_data);
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

if (!function_exists('csrf')) {
	function csrf(): string {
		return '<input type="hidden" name="_token" value="'.session()->get('_token').'">';
	}
}

if (!function_exists('redirect')) {
	function redirect(string $url = '', int $statusCode = 302, array $headers = []): Redirect
	{
		return new Redirect($url, $statusCode, $headers);
	}
}

if (!function_exists('response')) {
	function response(): Response {
		return new Response();
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