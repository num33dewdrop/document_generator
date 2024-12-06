<?php

namespace Http\Middlewares;

use Http\Requests\Request;
use Closure;

class ApiCsrfMiddleware implements MiddlewareInterface {
	private Request $request;

	public function __construct(Request $request) {
		$this->request = $request;
	}
	public function handle(Closure $next)
	{
		$response = ['error' => '', 'success' => ''];
		// 1. リクエスト検証
		if ($this->request->method() !== 'GET' && !$this->tokensMatch()) {
			$response['error'] = '認証に失敗しました。';
			response()->json($response, 403);
			die('CSRF token validation failed.');
		}
		// 2. トークンを再生成
		session()->put('_token', token());
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
		return $this->request->header('X-CSRF-Token') ?? null;
	}
}