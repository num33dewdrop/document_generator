<?php

namespace Session;

class Session {
	protected const FLASH_KEY = '_flash';

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
		$_SESSION[self::FLASH_KEY][$key] = $value;
	}

	// リクエストの終了時にフラッシュデータをクリア
	public function clearFlashData(): void {
		unset($_SESSION[self::FLASH_KEY]);
	}

	// フラッシュデータの読み込み
	protected function loadFlashData(): void {
		$_SESSION[self::FLASH_KEY] = $_SESSION[self::FLASH_KEY] ?? [];
	}

	// フラッシュデータの取得
	public function getFlash(string $key, $default = null) {
		return $_SESSION[self::FLASH_KEY][$key] ?? $default;
	}

	// リクエストが終了したときの処理
	public function __destruct() {
		$this->clearFlashData();
	}
}