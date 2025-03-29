<?php
namespace App\Http\Routes;

use App\Utilities\Debug;
use Closure;
use App\Containers\Container;
use Exception;
use App\Http\Kernel;
use App\Http\Middlewares\MiddlewareInterface;
use PDOException;
use ReflectionException;
use RuntimeException;

class Route {
	private static array $routes = [];
	private static array $middlewareStack = [];
	private static array $currentMiddleware = [];
	private static array $namedRoutes = [];
	private static string $lastMethod;
	private static Container $container;
	private static string $groupNamespace;
	private static bool $isApi;

	public static function load(string $path): void {
		// ルートファイルの読み込み
		require_once $path;
	}

	public static function namespace(string $value): self {
		self::$groupNamespace = $value;
		return new self;
	}
	public static function middleware(string $group): self
	{
		// ミドルウェアグループを追加
		self::$middlewareStack = Kernel::getMiddlewareGroup($group);
		self::$currentMiddleware = self::$middlewareStack;
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

	private static function registerRoute(string $method, string $uri, string | Closure $callback): void {
		self::$lastMethod = $method;
		self::$routes[$method][$uri] = [
			'namespace' => self::$groupNamespace,
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
		try {
			session()->start();
			self::$container = app();
			self::$isApi = isset($_SERVER['CONTENT_TYPE']) && str_contains( $_SERVER['CONTENT_TYPE'], 'application/json' );
			$requestUri = strtok($_SERVER['REQUEST_URI'], '?');
			$baseUri = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
			$path = str_replace($baseUri, '', $requestUri);
			self::$container->make('App\Providers\RouteServiceProvider');
			$method = self::$container->make('App\Http\Requests\Request')->method();
			foreach (self::$routes[$method] as $routePath => $route) {
				if (self::matchRoute($routePath, $path, $params)) {
					$namespace = $route['namespace'];
					$action = $route['callback'];
					$middlewares = $route['middleware'] ?? [];
					$next = function() use ($action, $namespace, $params, $path) {
						if (!self::isCallAction($action, $namespace, $params)) {
							error_log("メソッドの呼び出しに失敗しました");
							throw new RuntimeException("404 Not Found: $path", 404);
						}
					};
					foreach ($middlewares as $middleware) {
						$middlewareInstance = self::$container->make($middleware);
						if ($middlewareInstance instanceof MiddlewareInterface) {
							$next = function() use ($middlewareInstance, $next) {
								$middlewareInstance->handle($next);
							};
						}
					}
					$next();
					return;
				}
			}
			throw new RuntimeException("404 Not Found: $path", 404);
		} catch (ReflectionException $e) {
			error_log("ReflectionException: $e");
			self::handleError($e);
		} catch (PDOException $e) {
			error_log("PDOException: $e");
			self::handleError($e);
		} catch (RuntimeException $e) {
			error_log($e);
			redirect()->carry(["error" => $e->getMessage()])->back();
		}
	}

	// ルートパラメータの解決
	private static function matchRoute(string $routePath, string $path, array | null &$params): bool {
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

	protected static function isCallAction(string | Closure $action, string $namespace, array $params): bool {
		try {
			if (is_callable($action)) {
				call_user_func_array($action, $params);
				return true;
			}
			if (is_string($action)) {
				[$controller, $method] = explode('@', $action);
				$controller = $namespace . $controller;
				if (class_exists($controller)) {
					$controllerInstance = self::$container->make($controller);
					if (method_exists($controllerInstance, $method)) {
						self::$container->call([$controllerInstance, $method], $params);
						return true;
					}
				}
			}

		} catch (ReflectionException $e) {
			error_log("ReflectionException: $e");
			self::handleError($e);
		} catch (PDOException $e) {
			error_log("PDOException: $e");
			self::handleError($e);
		} catch (RuntimeException $e) {
			error_log($e);
			redirect()->carry(["error" => $e->getMessage()])->back();
		}

		return false;
	}

	private static function handleError(Exception $e): void {
		if(self::$isApi) {
			$response = ['error' => $e->getMessage()];
			response()->json($response, $e->getCode());
		}else {
			http_response_code($e->getCode());
			view('errors.notFound');
		}
	}
}