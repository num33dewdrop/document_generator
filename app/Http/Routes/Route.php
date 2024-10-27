<?php
namespace Http\Routes;

use Containers\Container;
use Http\Middleware\MiddlewareInterface;
use ReflectionException;

class Route {
	private static array $routes = [];
	protected static array $namedRoutes = [];
	protected static Container $container;
	private static array $currentMiddleware = [];

	// コンテナの初期化
	protected static array $middlewareAliases = [];

	public static function setContainer(Container $container): void {
		self::$container = $container;
	}

	public static function registerMiddlewareAliases(array $aliases): void {
		self::$middlewareAliases = $aliases;
	}

	public static function get($uri, $callback): static {
		self::registerRoute('GET', $uri, $callback);
		return new static;
	}

	public static function post($uri, $callback): static {
		self::registerRoute('POST', $uri, $callback);
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

	private static function registerRoute(string $method, string $uri, $callback): void {
		self::$routes[$method][$uri] = [
			'callback' => $callback,
			'middleware' => self::$currentMiddleware // 現在のミドルウェアを登録
		];
	}

	// グループ化されたルートにミドルウェアを適用するメソッド
	public static function group(array $options, callable $callback): void {
		if (isset($options['middleware'])) {
			self::$currentMiddleware = self::$middlewareAliases[$options['middleware']]; // 現在のミドルウェアを設定
		}
		call_user_func($callback);
		self::$currentMiddleware = []; // グループの後にリセット
	}

	public static function handleRequest(): void {
		$requestUri = strtok($_SERVER['REQUEST_URI'], '?'); // クエリパラメータを取り除く
		$method = $_SERVER['REQUEST_METHOD'];

		$baseUri = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); // スクリプト名からベースURIを取得
		$path = str_replace($baseUri, '', $requestUri); // ベースURIをリクエストURIから取り除く

		// ルートが登録されているか確認
		if (!isset(self::$routes[$method][$path])) {
			self::handleNotFound($path);
			return;
		}

		$route = self::$routes[$method][$path];
		$action = $route['callback'];
		$middlewares = $route['middleware'] ?? [];

		self::applyMiddlewares($middlewares, $action, $path);
	}
	private static function applyMiddlewares(array $middlewares, $action, $path): void {
		$next = function() use ( $path, $action) {
			if(!self::isCallAction($action)) {
				self::handleNotFound($path);
			}
		};

		foreach ($middlewares as $middleware) {
			try {
				$middlewareInstance = self::$container->make($middleware);
				if ($middlewareInstance instanceof MiddlewareInterface) {
					$next = function() use ($middlewareInstance, $next) {
						$middlewareInstance->handle($next);
					};
				}
			} catch (ReflectionException $e) {
				error_log("ReflectionException: $e"); // ログに残す
				self::handleNotFound($path); // エラー発生時は404
			}
		}

		$next(); // 最後にコールバックを実行
	}

	protected static function isCallAction($action): bool {
		// コントローラーとメソッドを解析
		if(is_callable($action)) {
			call_user_func($action);
			return true;
		}
		if (is_string($action)) {
			list($controller, $method) = explode('@', $action);
			$controller = 'Http\\Controllers\\' . $controller;
			if (class_exists($controller)) {
				try {
					$controllerInstance = self::$container->make( $controller );
					if(method_exists($controllerInstance, $method)) {
						self::$container->call($controllerInstance, $method);
						return true;
					}
				} catch ( ReflectionException $e ) {
					error_log("ReflectionException: $e"); // ログに残す
					return false;
				}
			}
		}
		return false;
	}

	// 404エラー処理を共通化
	private static function handleNotFound(string $path): void {
		http_response_code(404); // 404ステータスコードを返す
		echo "404 Not Found";
		error_log("404 Not Found: $path"); // ログに残す
	}
}