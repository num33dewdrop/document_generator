<?php

namespace Controllers\Auth;

use Controllers\Controller;
use Model\User;
use Validators\Validator;

class RegisterController extends Controller {
	public function index(): void {
		// セッションからエラーメッセージを取得
		$errors = $_SESSION['errors'] ?? [];
		unset($_SESSION['errors']); // エラーメッセージを削除
		$this->data['head']['title'] = 'USER REGISTER';
		$this->data['head']['description'] = 'REGISTERの説明';
		$this->data['errors'] = $errors;
		// ビューにエラーメッセージを渡して表示
		view('auth.user-register', $this->data);
	}
	public function register(): void {
		// POSTデータ
		$posts = [
			'name'  => $_POST['name'],
			'email' => $_POST['email'],
			'pass'  => $_POST['pass'],
			'pass_re' => $_POST['pass_re'],
		];

		// バリデーションルール
		$rules = [
			'name'  => ['required'],
			'email' => ['required', 'email'],
			'pass'  => ['required'],
			'pass_re' => ['required']
		];
		$user = new User($this->db);
		Validator::setUser($user);
		if(Validator::make($posts, $rules)) {
			$data = [
				':name'      => $posts['name'],
				':email'     => $posts['email'],
				':pass'      => password_hash( $posts['pass'], PASSWORD_DEFAULT ),
				':create_at' => date( 'Y-m-d H:i:s' )
			];
			if ($user->create($data)) {
				echo "User successfully registered!";
			} else {
				echo "Failed to register user.";
			}
		}else {
			$_SESSION['errors'] = Validator::getErrors();
			var_dump(Validator::getErrors());
		}
	}
}