<?php

namespace Http\Middleware;

use Auth\Auth;
use Closure;

class GuestMiddleware implements MiddlewareInterface {
	protected Auth $auth;

	public function __construct(Auth $auth) {
		$this->auth = $auth;
	}

	public function handle(Closure $next) {
		// ユーザーが認証されているか確認
		if ($this->auth->check()) {
			// 認証されている場合、特定のページにリダイレクト
			redirect()->route('documents-list.show');
		}
		return $next(); // 認証されていない場合は次の処理へ
	}
}