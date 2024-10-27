<?php
namespace Utilities;

class Debug {
	private static bool $debug_flg = true;
	public static function echo($str): void {
		if(!empty(self::$debug_flg)) {
			error_log('デバッグ：'.$str);
		}
	}
	//=================================================
	//画面表示処理開始ログ吐き出し関数
	//=================================================
	public static function start($str): void {
		Debug::echo('『『『『『『『『『『『『『『『『『『『『『『『『『『『『『『『');
		Debug::echo('『　'.$str.'　『');
		Debug::echo('『『『『『『『『『『『『『『『『『『『『『『『『『『『『『『『');
		Debug::echo('>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>画面表示処理開始');
		Debug::echo('sessionID：'.session_id());
		Debug::echo('session変数の中身：'.print_r($_SESSION, true));
		Debug::echo('現在日時タイムスタンプ'.time());
		if(!empty($_SESSION['login_time']) && !empty($_SESSION['login_limit'])){
			Debug::echo('ログイン有効期限タイムスタンプ：'.($_SESSION['login_time'] + $_SESSION['login_limit']));
		}
	}
	public static function end($str): void {
		Debug::echo('』』』』』』』』』』』』』』』』』』』』』』』』』』』』』』』');
		Debug::echo('』　'.$str.'　』');
		Debug::echo('』』』』』』』』』』』』』』』』』』』』』』』』』』』』』』』');
		Debug::echo('>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>画面表示処理終了');
	}
}