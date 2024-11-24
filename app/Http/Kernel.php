<?php

namespace Http;

use Http\Middlewares\ApiAuthenticationMiddleware;
use Http\Middlewares\AuthMiddleware;
use Http\Middlewares\CsrfMiddleware;
use Http\Middlewares\GuestMiddleware;

class Kernel
{
	// ミドルウェアグループの定義
	protected static array $middlewareGroups = [
		'web' => [
			CsrfMiddleware::class,
//			StartSessionMiddleware::class,
//			EncryptCookiesMiddleware::class,
		],
		'api' => [
//			ThrottleMiddleware::class,
			ApiAuthenticationMiddleware::class
		],
	];

	// 個別のミドルウェア
	protected static array $routeMiddleware = [
		'auth' => [AuthMiddleware::class],
		'guest' => [GuestMiddleware::class]
	];

	// ミドルウェアグループを取得
	public static function getMiddlewareGroup(string $group): array
	{
		return self::$middlewareGroups[$group] ?? [];
	}

	// 個別のミドルウェアを取得
	public static function getRouteMiddleware(string $name): array
	{
		return self::$routeMiddleware[$name] ?? [];
	}
}
