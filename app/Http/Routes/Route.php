<?php
namespace Http\Routes;

class Route {
	private static array $routes = [];
	protected static array $namedRoutes = [];

	public static function get($uri, $callback): static {
		self::$routes['GET'][$uri] = $callback;
		return new static;
	}

	public static function post($uri, $callback): static {
		self::$routes['POST'][$uri] = $callback;
		return new static;
	}

	public static function name(string $name): void {
		$lastRoute = end(self::$routes['GET']) ?? end(self::$routes['POST']);
		if ($lastRoute) {
			self::$namedRoutes[$name] = $lastRoute;
		}
	}

	public static function route(string $name): bool|int|string {
		foreach (self::$routes as $method => $routes) {
			if (($uri = array_search(self::$namedRoutes[$name], $routes)) !== false) {
				return $uri;
			}
		}
		return false;
	}

	public static function handleRequest(): void {
		$requestUri = strtok($_SERVER['REQUEST_URI'], '?'); // クエリパラメータを取り除く
		$method = $_SERVER['REQUEST_METHOD'];

		// ルートディレクトリを取り除く
		$baseUri = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); // スクリプト名からベースURIを取得
		$path = str_replace($baseUri, '', $requestUri); // ベースURIをリクエストURIから取り除く

		// ルートが登録されているか確認
		if (!isset(self::$routes[$method][$path])) {

			self::handleNotFound($path);
			return;
		}

		$action = self::$routes[$method][$path];

		// コントローラーとメソッドを解析
		if(is_callable($action)) {
			call_user_func($action);
			return;
		}

		if (is_string($action)) {
			list($controller, $method) = explode('@', $action);
			// クラスを動的にインスタンス化し、メソッドを呼び出す
			$controllerClass = "Http\\Controllers\\" . $controller;
			if (class_exists($controllerClass)) {
				$controllerInstance = new $controllerClass();
				if (method_exists($controllerInstance, $method)) {
					call_user_func([$controllerInstance, $method]);
					return;
				}
			}
		}

		self::handleNotFound($path);
	}

	// 404エラー処理を共通化
	private static function handleNotFound(string $path): void {
		http_response_code(404); // 404ステータスコードを返す
		echo "404 Not Found";
		error_log("404 Not Found: $path"); // ログに残す
	}
}