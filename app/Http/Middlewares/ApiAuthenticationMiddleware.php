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

		if ($apiToken !== 'your-secure-api-token') {
			response()->json(['error' => 'Unauthorized'], 401);
			exit; // ここで終了
		}

		return $next();
	}
}