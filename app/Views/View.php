<?php
namespace Views;

class View {
	public static function render($view, $data = [], $type = ""): void {
		$viewPath = base_path('resources/views/' . $view . '.php');
		// ビューが存在するか確認
		if (file_exists($viewPath)) {
			// データを変数として展開
			extract($data);
			// ビューを読み込み
			require $viewPath;
			session()->remove('errors');
			session()->remove('old');
		} else {
			// ビューが見つからない場合はエラーメッセージを表示
			http_response_code(404); // 404ステータスコードを返す
			view('errors.notFound');
			error_log("View not found: $view");
		}
	}

	public static function include($view, $parts_data = []):void {
		$viewPath = base_path('resources/views/common/' . $view . '.php');
		// ビューが存在するか確認
		if (file_exists($viewPath)) {
			// データを変数として展開
			extract($parts_data);
			// ビューを読み込み
			include $viewPath;
		} else {
			// ビューが見つからない場合はエラーメッセージを表示
			http_response_code(404); // 404ステータスコードを返す
			view('errors.notFound');
			error_log("View not found: $view");
		}
	}
}