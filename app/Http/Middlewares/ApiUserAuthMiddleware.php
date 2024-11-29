<?php

namespace Http\Middlewares;

use Auth\Auth;
use Closure;

class ApiUserAuthMiddleware implements MiddlewareInterface {
	//インターフェイスに含まれる全てのメソッドを実装する必要がある
	protected Auth $auth;

	public function __construct(Auth $auth) {
		$this->auth = $auth;
	}

	public function handle(Closure $next) {
		$response = ['error' => '', 'success' => ''];
		if (!$this->auth->check()) {
			$response['error'] = 'アクセス権限が制限されています。';
			response()->json($response, 403);
		}
		return $next(); // 認証成功時に次の処理へ
	}
}