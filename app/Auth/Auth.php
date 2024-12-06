<?php

namespace Auth;

//use Models\ApiToken;
use Models\User;

class Auth {
	private User $userModel;
	protected array $messages;
	protected array $errors = [];
//	private ApiToken $apiTokenModel;

	public function __construct(User $userModel) {
		$this->messages = require base_path('config/auth.php');
		$this->userModel = $userModel;
//		$this->apiTokenModel = $apiTokenModel;
	}

	public function attempt(array $credentials): bool {
		// ユーザーをデータベースから取得
		$user = $this->userModel->findByEmail($credentials['email']);
		if (!$user || !password_verify($credentials['password'], $user['password'])) {
			$this->errors = ['common' => [$this->messages['failed'] ?? 'auth error.']];
			error_log('認証に失敗しました。');
			return false; // 認証失敗
		}
//		if(!$this->apiTokenModel->update($user['id'])) {
//			$this->errors = ['common' => [$this->messages['failed'] ?? 'auth error.']];
//			error_log('トークンの更新に失敗しました。');
//			return false; // トークン更新失敗
//		}
		// 認証成功
		$sesLimit = 60 * 60;
		session()->put('login_date', time());
		session()->put('login_limit', $credentials['password_save'] ? $sesLimit * 24 * 30 : $sesLimit);
		session()->put('user_id', $user['id']);

		return true;
	}

	public function getErrors(): array {
		return $this->errors;
	}

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