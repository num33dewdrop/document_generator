<?php

namespace App\Http\Controllers;

use App\Auth\Auth;

class Controller {
	protected array $data = [];
	protected Auth $auth;
	protected array $config;


	public function __construct(Auth $auth) {
		$id = session()->get("user_id");
		$this->auth = $auth;
		$this->config = require base_path('config/auth.php');
		if(isset($id)) {
			$this->data["user"] = $this->auth->user->findById($id);
		}
	}
}