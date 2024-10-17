<?php
namespace Views;

class View {
	public static function render($view, $data = []): void {
		$viewPath = base_path('resources/views/' . $view . '.php');
		// ビューが存在するか確認
		if (file_exists($viewPath)) {
			// データを変数として展開
			extract($data);
			// ビューを読み込み
			require $viewPath;
		} else {
			// ビューが見つからない場合はエラーメッセージを表示
			http_response_code(404); // 404ステータスコードを返す
			echo "View not found: $view";
			error_log("View not found: $view");
		}
	}

	public static function include($view, $data = []):void {
		$viewPath = base_path('resources/views/common/' . $view . '.php');
		// ビューが存在するか確認
		if (file_exists($viewPath)) {
			// データを変数として展開
			extract($data);
			// ビューを読み込み
			include $viewPath;
		} else {
			// ビューが見つからない場合はエラーメッセージを表示
			http_response_code(404); // 404ステータスコードを返す
			echo "View not found: $view";
			error_log("View not found: $view");
		}
	}
}