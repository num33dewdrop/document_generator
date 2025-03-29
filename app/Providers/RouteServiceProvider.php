<?php

namespace App\Providers;

use App\Http\Routes\Route;

class RouteServiceProvider {
	protected string $namespace = 'App\\Http\\Controllers\\';
	public function __construct() {
		$this->mapApiRoutes();
		$this->mapWebRoutes();
		$this->mapOutsideRoutes();
	}

	protected function mapWebRoutes(): void {
		// webミドルウェアグループを適用してルートを読み込む
		Route::middleware('web')
			->namespace($this->namespace.'Web\\')
			->load(base_path('routes/web.php'));
	}

	protected function mapApiRoutes(): void {
		// apiミドルウェアグループを適用してルートを読み込む
		Route::middleware('api')
			->namespace($this->namespace.'Api\\')
			->load(base_path('routes/api.php'));
	}

	protected function mapOutsideRoutes(): void {
		// apiミドルウェアグループを適用してルートを読み込む
		Route::middleware('outside')
		     ->namespace($this->namespace.'Outside\\')
		     ->load(base_path('routes/outside.php'));
	}
}