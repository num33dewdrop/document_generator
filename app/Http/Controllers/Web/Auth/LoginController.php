<?php

namespace Http\Controllers\Web\Auth;

use Auth\Auth;
use Http\Controllers\Controller;
use Http\Requests\Request;
use Utilities\Debug;
use Validators\Validator;

class LoginController extends Controller  {

	public function index(): void {
		Debug::start('USER LOGIN INDEX');
		// ビューにエラーメッセージを渡して表示
		view('users.auth.login', $this->data);
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

		$request->validate();

		$this->auth->attempt($request->postAll());

		redirect()->route('documents-list.show');
		Debug::end('USER LOGIN');
	}

	public function logout(): void {
		Debug::start('USER LOGOUT');
		$this->auth->logout();
		redirect()->route('user-login.index'); // ログアウト後にログイン画面へ
		Debug::end('USER LOGOUT');
	}
}