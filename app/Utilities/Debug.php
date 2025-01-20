<?php
namespace App\Utilities;

class Debug {
	private static bool $debug_flg = true;
	public static function echo($str): void {
		if(!empty(self::$debug_flg)) {
			error_log('デバッグ：'.print_r($str, true));
		}
	}
	//=================================================
	//画面表示処理開始ログ吐き出し関数
	//=================================================
	public static function start($str): void {
		self::echo('『『『『『『『『『『『『『『『『『『『『『『『『『『『『『『『');
		self::echo('『　'.$str.'　『');
		self::echo('『『『『『『『『『『『『『『『『『『『『『『『『『『『『『『『');
		self::echo('>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>画面表示処理開始');
		self::echo('sessionID：'.session_id());
		self::echo('session変数の中身：'.print_r($_SESSION, true));
		self::echo('現在日時タイムスタンプ'.time());
		if(!empty(session()->get('login_date')) && !empty(session()->get('limit'))){
			self::echo('ログイン有効期限タイムスタンプ：'.(session()->get('login_date') + session()->get('login_date')));
		}
	}
	public static function end($str): void {
		self::echo('』』』』』』』』』』』』』』』』』』』』』』』』』』』』』』』');
		self::echo('』　'.$str.'　』');
		self::echo('』』』』』』』』』』』』』』』』』』』』』』』』』』』』』』』');
		self::echo('>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>画面表示処理終了');
	}
}