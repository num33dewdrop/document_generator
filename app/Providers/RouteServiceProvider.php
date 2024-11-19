<?php

namespace Providers;

use Http\Routes\Route;

class RouteServiceProvider {
	public function __construct() {
		$this->mapApiRoutes();
		$this->mapWebRoutes();
	}

	protected function mapWebRoutes(): void {
		// webミドルウェアグループを適用してルートを読み込む
		Route::middleware('web')->load(base_path('routes/web.php'));
	}

	protected function mapApiRoutes(): void {
		// apiミドルウェアグループを適用してルートを読み込む
		Route::middleware('api')
		      ->load(base_path('routes/api.php'));
	}
}