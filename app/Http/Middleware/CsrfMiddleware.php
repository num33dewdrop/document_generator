<?php

namespace Http\Middleware;

use Closure;
use Http\Requests\Request;
use Utilities\Debug;

class CsrfMiddleware implements MiddlewareInterface {

	//インターフェイスに含まれる全てのメソッドを実装する必要がある
	protected Request $request;

	public function __construct(Request $request) {
		$this->request = $request;
	}
	public function handle( Closure $next ) {
		// 1. リクエスト検証
		if ($this->request->method() !== 'GET' && !$this->tokensMatch()) {
			http_response_code(403);
			die('CSRF token validation failed.');
		}
		// 2. トークンを再生成
		session()->put('_token', csrf_token());
		return $next();
	}
	protected function tokensMatch(): bool {
		// リクエストからトークンを取得
		$token = $this->getTokenFromRequest();

		// セッションからトークンを取得
		$sessionToken = session()->get('_token') ?? null;

		// トークンを比較
		return is_string($sessionToken) && is_string($token) && hash_equals($sessionToken, $token);
	}
	protected function getTokenFromRequest(): string | null
	{
		// フォームデータかヘッダーからトークンを取得
		return $this->request->input('_token') ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
	}
}