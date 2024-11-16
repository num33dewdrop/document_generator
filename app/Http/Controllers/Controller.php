<?php

namespace Http\Controllers;

use Auth\Auth;

class Controller {
	protected array $data = [];
	protected Auth $auth;

	public function __construct(Auth $auth) {
		$this->auth = $auth;
	}
}