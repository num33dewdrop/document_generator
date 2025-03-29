<?php

namespace App\Http\Controllers\Web\Auth;

use App\Database\Connection;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Providers\GoogleServiceProvider;
use App\Utilities\Debug;
use Google_Service_Drive;
use Google_Service_Sheets;

class LoginController extends Controller {
	public function index(): void {
		Debug::start('USER LOGIN INDEX');
		$this->data['client_id'] = $this->config['google']['client_id'];
		// ビューにエラーメッセージを渡して表示
		view('users.auth.login', $this->data);
		Debug::end('USER LOGIN INDEX');
	}

	public function google (GoogleServiceProvider $google_service_provider): void {
		Debug::start('USER GOOGLE LOGIN');

		$client = $google_service_provider->setup(
			$this->config['google']['client_id'],
			$this->config['google']['secret'],
			base_domain().route('user-redirect.store'),
			$this->config['google']['scope']
		);

		$google_service_provider->redirectToGoogle($client);
	}

//	public function login(Request $request): void {
//		Debug::start('USER LOGIN');
//		// バリデーションルール
//		$rules = [
//			'email' => 'required|email',
//			'password' => 'required',
//		];
//
//		$request->setRules($rules);
//
//		$request->validate();
//
//		$this->auth->attempt($request->postAll());
//
//		redirect()->route('documents-list.show');
//		Debug::end('USER LOGIN');
//	}

	public function logout(): void {
		Debug::start('USER LOGOUT');
		$this->auth->logout();
		redirect()->route('user-login.index'); // ログアウト後にログイン画面へ
		Debug::end('USER LOGOUT');
	}
}