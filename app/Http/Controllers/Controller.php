<?php

namespace App\Http\Controllers;

use App\Auth\Auth;

class Controller {
	protected array $data = [];
	protected Auth $auth;

	public function __construct(Auth $auth) {
		$id = session()->get("user_id");
		$this->auth = $auth;
		if(isset($id)) {
			$this->data["user"] = $this->auth->user->findById($id);
		}
	}
}