<?php
namespace Routes;
use Controllers\DocumentsController;

class Route {
	private static array $routes = [];
	protected static array $namedRoutes = [];

	public static function get($uri, $callback): static {
		self::$routes['GET'][$uri] = $callback;
		return new static;
	}

	public static function post($uri, $callback): void {
		self::$routes['POST'][$uri] = $callback;
	}

	public static function name(string $name): void {
		self::$namedRoutes[$name] = end(self::$routes['GET']);
	}

	public static function route(string $name): bool|int|string {
		return array_search(self::$namedRoutes[$name], self::$routes['GET']);
	}

	public static function handleRequest(): void {
		$requestUri = strtok($_SERVER['REQUEST_URI'], '?'); // クエリパラメータを取り除く
		$method = $_SERVER['REQUEST_METHOD'];

		// ルートディレクトリを取り除く
		$baseUri = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); // スクリプト名からベースURIを取得
		$path = str_replace($baseUri, '', $requestUri); // ベースURIをリクエストURIから取り除く

		// ルートが登録されているか確認
		if (isset(self::$routes[$method][$path])) {
			$action = self::$routes[$method][$path];

			// コントローラーとメソッドを解析
			if (is_string($action)) {
				list($controller, $method) = explode('@', $action);

				// クラスを動的にインスタンス化し、メソッドを呼び出す
				$controller = "Controllers\\" . $controller;
				$controller = new $controller();
				call_user_func([$controller, $method]);
			} elseif (is_callable($action)) {
				call_user_func($action);
			} else {
				http_response_code(404); // 404ステータスコードを返す
				echo "404 Not Found";
				error_log("404 Not Found 1: $path"); // ログに残す
			}
		} else {
			http_response_code(404); // 404ステータスコードを返す
			echo "404 Not Found";
			error_log("404 Not Found 2: $path"); // ログに残す
		}
	}
}