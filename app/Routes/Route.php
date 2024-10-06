<?php
namespace Routes;

class Route {
	private static array $routes = [];

	public static function get($uri, $callback): void {
		self::$routes['GET'][$uri] = $callback;
	}

	public static function post($uri, $callback): void {
		self::$routes['POST'][$uri] = $callback;
	}

	public static function handleRequest(): void {
		$requestUri = strtok($_SERVER['REQUEST_URI'], '?'); // クエリパラメータを取り除く
		$method = $_SERVER['REQUEST_METHOD'];

		// ルートディレクトリを取り除く
		$baseUri = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); // スクリプト名からベースURIを取得
		$path = str_replace($baseUri, '', $requestUri); // ベースURIをリクエストURIから取り除く

		// ルートが登録されているか確認
		if (isset(self::$routes[$method][$path])) {
			call_user_func(self::$routes[$method][$path]);
		} else {
			http_response_code(404); // 404ステータスコードを返す
			echo "404 Not Found";
			error_log("404 Not Found: $path"); // ログに残す
		}
	}
}