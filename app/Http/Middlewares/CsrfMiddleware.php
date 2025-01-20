<?php

namespace App\Http\Middlewares;

use Closure;
use App\Http\Requests\Request;
use RuntimeException;
use App\Utilities\Debug;

class CsrfMiddleware implements MiddlewareInterface {

	//インターフェイスに含まれる全てのメソッドを実装する必要がある
	protected Request $request;

	public function __construct(Request $request) {
		$this->request = $request;
	}
	public function handle( Closure $next ) {
		// 1. リクエスト検証
//		if ($this->request->method() === 'GET') {
//			throw new RuntimeException('Method Not Allowed', 405);
//		}
		if ($this->request->method() !== 'GET' && !$this->tokensMatch()) {
			throw new RuntimeException('認証に失敗しました。', 403);
		}
		// 2. トークンを再生成
		session()->put('_token', token());
		return $next();
	}
	protected function tokensMatch(): bool {
		// リクエストからトークンを取得
		$token = $this->request->input('_token') ?? null;

		// セッションからトークンを取得
		$sessionToken = session()->get('_token') ?? null;

		// トークンを比較
		return is_string($sessionToken) && is_string($token) && hash_equals($sessionToken, $token);
	}
}