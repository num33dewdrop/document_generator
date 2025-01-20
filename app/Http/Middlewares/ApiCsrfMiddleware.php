<?php

namespace App\Http\Middlewares;

use App\Http\Requests\Request;
use Closure;
use RuntimeException;

class ApiCsrfMiddleware implements MiddlewareInterface {
	private Request $request;

	public function __construct(Request $request) {
		$this->request = $request;
	}
	public function handle(Closure $next)
	{
		// 1. リクエスト検証
		if ($this->request->method() !== 'GET' && !$this->tokensMatch()) {
			throw new RuntimeException('認証に失敗しました', 403);
		}
		// 2. トークンを再生成
		session()->put('_token', token());
		return $next();
	}

	protected function tokensMatch(): bool {
		// リクエストからトークンを取得
		$token = $this->request->header('X-CSRF-Token') ?? null;
		// セッションからトークンを取得
		$sessionToken = session()->get('_token') ?? null;
		// トークンを比較
		return is_string($sessionToken) && is_string($token) && hash_equals($sessionToken, $token);
	}
}