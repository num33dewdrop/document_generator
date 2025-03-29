<?php

namespace App\Auth;

use App\Models\User;

class Auth {
	public User $user;
	protected array $messages;
	protected array $errors = [];

	public function __construct(User $user) {
		$this->messages = require base_path('config/auth.php');
		$this->user = $user;
	}
// googleログインのみにしたので不要
//	public function attempt(array $credentials): void {
//		// ユーザーをデータベースから取得
//		$user = $this->user->findByEmail($credentials['email']);
//		if (!$user || !password_verify($credentials['password'], $user['password'])) {
//			error_log('認証に失敗しました。');
//			session()->put('errors', ['common' => [$this->messages['errors']['failed'] ?? 'auth error.']]);
//			redirect()->back();
//		}
//		// 認証成功
//		$sesLimit = 60 * 60;
//		session()->put('login_date', time());
//		session()->put('login_limit', empty($credentials['password_save']) ? $sesLimit: $sesLimit * 24 * 30 );
//		session()->put('user_id', $user['id']);
//		session()->remove('errors');
//		session()->remove('old');
//	}

	public function logout(): void {
		session()->destroy();
	}

	public function check(): bool {
		if(empty(session()->get('user_id'))) {
			return false;
		}
		if(session()->get('login_date') + session()->get('login_limit') < time()) {
			//ログアウト
			$this->logout();
			return false;
		}
		session()->put('login_date', time());
		return true;
	}
}