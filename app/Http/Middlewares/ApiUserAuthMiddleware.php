<?php

namespace App\Http\Middlewares;

use App\Auth\Auth;
use Closure;
use RuntimeException;

class ApiUserAuthMiddleware implements MiddlewareInterface {
	//インターフェイスに含まれる全てのメソッドを実装する必要がある
	protected Auth $auth;

	public function __construct(Auth $auth) {
		$this->auth = $auth;
	}

	public function handle(Closure $next) {
		if (!$this->auth->check()) {
			throw new RuntimeException('アクセス権限が制限されています。', 403);
		}
		return $next(); // 認証成功時に次の処理へ
	}
}