<?php

namespace Http\Controllers\Auth;

use Http\Controllers\Controller;
use Http\Requests\Request;
use Utilities\Debug;
use Validators\Validator;

class LoginController extends Controller  {
	public function index(): void {
		Debug::start('USER LOGIN INDEX');
		$this->data['head']['title'] = 'USER REGISTER';
		$this->data['head']['description'] = 'REGISTERの説明';
		// ビューにエラーメッセージを渡して表示
		view('auth.user-login', $this->data);
		Debug::end('USER LOGIN INDEX');
	}

	public function login(Request $request): void {
		Debug::start('USER LOGIN');
		// バリデーションルール
		$rules = [
			'email' => 'required|email',
			'password' => 'required',
		];

		$request->setRules($rules);

		if(!$request->validate()) {
			$_SESSION['errors'] = Validator::getErrors();
			$_SESSION['old'] = $request->all();
			redirect()->back();
			return;
		}

		if (!$this->auth->attempt($request->all())) {
			$_SESSION['errors'] = $this->auth->getErrors();
			redirect()->back();
			return;
		}

		redirect()->route('documents.list');
		Debug::end('USER LOGIN');
	}

	public function logout(): void {
		Debug::start('USER LOGOUT');
		$this->auth->logout();
		redirect()->route('user-login.index'); // ログアウト後にログイン画面へ
		Debug::end('USER LOGOUT');
	}
}