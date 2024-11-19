<?php
namespace Http\Routes;

use Containers\Container;
use Http\Kernel;
use Http\Middleware\MiddlewareInterface;
use ReflectionException;
use Utilities\Debug;

class Route {
	private static array $routes = [];
	private static array $middlewareStack = [];
	private static array $currentMiddleware = [];
	private static array $namedRoutes = [];
	private static string $lastMethod;
	private static Container $container;

	public static function load(string $path): void {
		// ルートファイルの読み込み
		require_once $path;
	}
	public static function middleware(string $group): self
	{
		// ミドルウェアグループを追加
		$middlewares = Kernel::getMiddlewareGroup($group);
		self::$middlewareStack = array_merge(self::$middlewareStack, $middlewares);
		return new self;
	}

	public static function get($uri, $callback): static {
		self::registerRoute('GET', $uri, $callback);
		return new static;
	}

	public static function post($uri, $callback): static {
		self::registerRoute('POST', $uri, $callback);
		return new static;
	}

	public static function put($uri, $callback): static {
		self::registerRoute('PUT', $uri, $callback);
		return new static;
	}

	public static function delete($uri, $callback): static {
		self::registerRoute('DELETE', $uri, $callback);
		return new static;
	}

	public static function name(string $name): void {
		$lastRoute = end(self::$routes[self::$lastMethod]);
		// 名前付きルートを定義
		if ($lastRoute) {
			self::$namedRoutes[$name] = $lastRoute;
		}
	}

	public static function route(string $name, array $params = []): false | string {
		if (!isset(self::$namedRoutes[$name])) {
			return false;
		}
		// すべてのHTTPメソッドを対象に探索
		$httpMethods = ['GET', 'POST', 'PUT', 'DELETE'];
		$uri = false;
		foreach ($httpMethods as $method) {
			if (isset(self::$routes[$method])) {
				$uri = array_search(self::$namedRoutes[$name], self::$routes[$method]);
				if ($uri !== false) {
					break;
				}
			}
		}
		if ($uri === false) {
			return false;
		}
		// パラメータの解決
		foreach ($params as $key => $value) {
			$uri = str_replace('{' . $key . '}', $value, $uri);
		}

		return $uri;
	}

	private static function registerRoute(string $method, string $uri, $callback): void {
		self::$lastMethod = $method;
		self::$routes[$method][$uri] = [
			'callback' => $callback,
			'middleware' => self::$currentMiddleware // 現在のミドルウェアを登録
		];
	}

	// グループ化されたルートにミドルウェアを適用するメソッド
	public static function group(array $options, callable $callback): void {
		if (isset($options['middleware'])) {
			$middlewares = Kernel::getRouteMiddleware($options['middleware']);
			// 現在のミドルウェアを設定
			self::$currentMiddleware = array_merge(self::$middlewareStack, $middlewares);
		}
		// コールバックを実行
		call_user_func($callback);
		// グループの後にリセット
		self::$currentMiddleware = [];
	}

	public static function handleRequest(): void {
		session()->start();
		self::$container = app();
		$requestUri = strtok($_SERVER['REQUEST_URI'], '?');
		$baseUri = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
		$path = str_replace($baseUri, '', $requestUri);
		try {
			self::$container->make('Providers\RouteServiceProvider');
			$method = self::$container->make('Http\Requests\Request')->method();
			foreach (self::$routes[$method] as $routePath => $route) {
				if (self::matchRoute($routePath, $path, $params)) {
					$action = $route['callback'];
					$middlewares = $route['middleware'] ?? [];
					self::applyMiddlewares($middlewares, $action, $params, $path);
					return;
				}
			}
		} catch (ReflectionException $e) {
			error_log("ReflectionException: $e");
		}
		self::handleNotFound($path);
	}

	// ルートパラメータの解決
	private static function matchRoute(string $routePath, string $path, &$params): bool {
		$regex = preg_replace('/{(\w+)}/', '(?P<$1>[^/]+)', $routePath);
		if (preg_match('#^' . $regex . '$#', $path, $matches)) {
			foreach ($matches as $key => $value) {
				if(! is_int($key)) $params[$key] = $value;
			}
			if(is_null($params)) $params = [];
			return true;
		}
		$params = [];
		return false;
	}

	private static function applyMiddlewares(array $middlewares, $action, $params, $path): void {
		$next = function() use ($action, $params, $path) {
			if (!self::isCallAction($action, $params)) {
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
				error_log("ReflectionException: $e");
				self::handleNotFound($path);
			}
		}
		$next();
	}

	protected static function isCallAction($action, array $params): bool {
		if (is_callable($action)) {
			call_user_func_array($action, $params);
			return true;
		}
		if (is_string($action)) {
			[$controller, $method] = explode('@', $action);
			$controller = 'Http\\Controllers\\' . $controller;
			if (class_exists($controller)) {
				try {
					$controllerInstance = self::$container->make($controller);
					if (method_exists($controllerInstance, $method)) {

						self::$container->call([$controllerInstance, $method], $params);
						return true;
					}
				} catch (ReflectionException $e) {
					error_log("ReflectionException: $e");
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