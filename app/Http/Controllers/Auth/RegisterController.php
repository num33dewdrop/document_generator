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
		$this->data['head']['title'] = 'USER REGISTER';
		$this->data['head']['description'] = 'REGISTERの説明';
		// ビューにエラーメッセージを渡して表示
		view('auth.user-register', $this->data);
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
			$_SESSION['errors'] = Validator::getErrors();
			$_SESSION['old'] = $request->all();
			redirect()->back();
			return;
		}

		if (!$user->create($request->all())) {
			redirect()->back();
		}

		$sesLimit                = 60 * 60;
		$_SESSION['login_date']  = time();
		$_SESSION['login_limit'] = $sesLimit;
		$_SESSION['user_id']     = $this->db->getPdo()->lastInsertId();

		redirect()->route('documents.list');
		Debug::end('USER REGISTER STORE');
	}
}