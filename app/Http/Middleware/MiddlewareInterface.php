<?php

namespace Http\Middleware;

use Closure;

interface MiddlewareInterface {
	public function handle(Closure $next);
}