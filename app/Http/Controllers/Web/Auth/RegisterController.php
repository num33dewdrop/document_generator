<?php

namespace Http\Controllers\Web\Auth;

use Database\Connection;
use Http\Controllers\Controller;
use Http\Requests\Request;
use Models\User;
use Utilities\Debug;
use Validators\Validator;

class RegisterController extends Controller {
	public function index(): void {
		Debug::start('USER REGISTER INDEX');
		// ビューにエラーメッセージを渡して表示
		view('users.auth.register', $this->data);
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

		$request->validate($user);

		$user->create($request->postAll());

		if (!Connection::impactCheck()) {
			redirect()->carry(['error' => '登録に失敗しました。'])->back();
		}

		$sesLimit = 60 * 60;
		session()->put('login_date', time());
		session()->put('login_limit', $sesLimit);
		session()->put('user_id', Connection::getPdo()->lastInsertId());

		redirect()->route('documents-list.show');
	}
}