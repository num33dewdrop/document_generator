<?php

namespace Http\Controllers\Auth;

use Http\Controllers\Controller;
use Http\Requests\Request;
use Models\User;
use Utilities\Debug;
use Validators\Validator;

class RegisterController extends Controller {
	public function index(): void {
		Debug::start('USER REGISTER INDEX');
		// セッションからエラーメッセージを取得
		$errors = $_SESSION['errors'] ?? [];
		unset($_SESSION['errors']); // エラーメッセージを削除
		$this->data['head']['title'] = 'USER REGISTER';
		$this->data['head']['description'] = 'REGISTERの説明';
		$this->data['errors'] = $errors;
		// ビューにエラーメッセージを渡して表示
		view('auth.user-register', $this->data);
		Debug::end('USER REGISTER INDEX');
	}
	public function store(): void {
		Debug::start('USER REGISTER STORE');
		// バリデーションルール
		$rules = [
			'name' => 'required|string|max:12',
			'email' => 'required|email',
			'password' => 'required|min:8',
			'password_re' => 'required|same:password',
		];

		$request = new Request($_POST, $rules, $this->db);

		if(!$request->validate()) {
			$_SESSION['errors'] = Validator::getErrors();
			redirect()->back();
			return;
		}

		$user = new User($this->db);

		if (!$user->create($request->all())) {
			redirect()->back();
		}

		$sesLimit                = 60 * 60;
		$_SESSION['login_date']  = time();
		$_SESSION['login_limit'] = $sesLimit;
		$_SESSION['user_id']     = $this->db->getPdo()->lastInsertId();

		redirect()->route('documents.list');
		Debug::end('USER REGISTER STORE');
		exit;
	}
}