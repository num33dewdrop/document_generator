<?php

namespace App\Session;

use RuntimeException;

class Session {
	protected const FLASH_KEY = '_flash';
	const FLASH_NEXT_KEY = '_flash_next';

	public function __construct() {}

	public function start(): void {
		if (session_status() === PHP_SESSION_NONE) {
			session_save_path('/var/tmp/');
			//ガーベージコレクションが削除するsessionの有効期限を設定
			ini_set('session.gc_maxlifetime', 60*60*24*30);
			//ブラウザを閉じても削除されないようにクッキー自体の有効期限を延ばす
			ini_set('session.cookie_lifetime', 60*60*24*30);
			//sessionを使う
			session_start();
			//現在のsessionIDを新しく生成したものに置き換える
			session_regenerate_id();

			if (empty($this->get('_token'))) {
				try {
					$this->put('_token', token());
				} catch (RuntimeException $e) {
					// トークン生成に失敗した場合の処理
					error_log("トークン生成に失敗: ".$e->getMessage());
					throw new RuntimeException("予期しないエラーが発生しました。時間をおいて再試行してください。", 500);
				}
			}
		}
	}
	// データの取得
	public function get(string $key, $default = null) {
		return $_SESSION[$key] ?? $default;
	}

	// データのセット
	public function put(string $key, $value): void {
		$_SESSION[$key] = $value;
	}

	// データの削除
	public function remove(string $key): void {
		unset($_SESSION[$key]);
	}

	public function destroy(): void {
		session_destroy();
	}

	// フラッシュデータのセット
	public function flash(string $key, $value): void {
		$_SESSION[self::FLASH_NEXT_KEY][$key] = $value;
	}

	// リクエストの終了時にフラッシュデータをクリア
	public function clearFlashData(): void {
		// 現在のフラッシュデータを移動
		$_SESSION[self::FLASH_KEY] = $_SESSION[self::FLASH_NEXT_KEY] ?? [];
		// 次回用のフラッシュデータをリセット
		unset($_SESSION[self::FLASH_NEXT_KEY]);
	}

	// フラッシュデータの取得
	public function getFlash(string $key, $default = null) {
		return $_SESSION[self::FLASH_KEY][$key] ?? $default;
	}

	public function __destruct() {
		$this->clearFlashData();
	}
}