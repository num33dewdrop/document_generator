<?php

namespace App\Http;

use App\Http\Middlewares\ApiCsrfMiddleware;
use App\Http\Middlewares\AuthMiddleware;
use App\Http\Middlewares\CsrfMiddleware;
use App\Http\Middlewares\GuestMiddleware;

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
			ApiCsrfMiddleware::class
		],
		'outside' => [

		]
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
