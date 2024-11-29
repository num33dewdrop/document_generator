<?php

namespace Http\Middlewares;

use Http\Requests\Request;
use Closure;

class ApiAuthenticationMiddleware implements MiddlewareInterface {
	private Request $request;

	public function __construct(Request $request) {
		$this->request = $request;
	}
	public function handle(Closure $next)
	{
		$apiToken = $this->request->header('x-auth-token');
		$response = ['error' => '', 'success' => ''];

		if ($apiToken !== 'your-secure-api-token') {
			$response['error'] = '認証に失敗しました。';
			response()->json($response, 401);
		}

		return $next();
	}
}