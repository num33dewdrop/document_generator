<?php

namespace Auth;

use Models\User;

class Auth {
	private User $userModel;
	protected array $messages;
	protected array $errors = [];

	public function __construct(User $userModel) {
		$this->messages = require base_path('config/auth.php');
		$this->userModel = $userModel;
	}

	public function attempt(array $credentials): bool {
		// ユーザーをデータベースから取得
		$user = $this->userModel->findByEmail($credentials['email']);
		if (!$user || !password_verify($credentials['password'], $user['password'])) {
			$this->errors = ['common' => [$this->messages['failed'] ?? 'auth error.']];
			return false; // 認証失敗
		}
		// 認証成功
		$sesLimit                = 60 * 60;
		$_SESSION['login_date']  = time();
		$_SESSION['login_limit'] = $credentials['password_save'] ? $sesLimit * 24 * 30 : $sesLimit;
		$_SESSION['user_id']     = $user['id'];
		return true;
	}

	public function getErrors(): array {
		return $this->errors;
	}

	public function logout(): void {
		session_destroy();
	}

	public function check(): bool {
		if(empty($_SESSION['user_id'])) {
			return false;
		}

		if($_SESSION['login_date'] + $_SESSION['login_limit'] < time()) {
			//ログアウト
			$this->logout();
			return false;
		}

		$_SESSION['login_date'] = time();
		return true;
	}
}