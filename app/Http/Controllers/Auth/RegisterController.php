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
		// ビューにエラーメッセージを渡して表示
		view('auth.user-register', $this->data);
		session()->remove('errors');
		session()->remove('old');
		Debug::end('USER REGISTER INDEX');
	}
	public function store(Request $request, User $user): void {
		Debug::start('USER REGISTER STORE');
		// バリデーションルール
		$rules = [
			'name' => 'required|string|max:12',
			'email' => 'required|email|email-duplicate',
			'password' => 'required|min:8',
			'password_re' => 'required|same:password',
		];

		$request->setRules($rules);

		if(!$request->validate()) {
			session()->put('errors', Validator::getErrors());
			session()->put('old', $request->all());
			redirect()->back();
			return;
		}

		if (!$user->create($request->all())) {
			redirect()->back();
		}

		session()->remove('errors');
		session()->remove('old');

		$sesLimit = 60 * 60;
		session()->put('login_date', time());
		session()->put('login_limit', $sesLimit);
		session()->put('user_id', $user->getDatabase()->getPdo()->lastInsertId());

		redirect()->route('documents-list.show');
		Debug::end('USER REGISTER STORE');
	}
}