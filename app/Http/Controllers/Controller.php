<?php

namespace Http\Controllers;

use Auth\Auth;
use Database\Connection;

class Controller {
	protected array $data = [
		'head' => [
			'title' => 'HOME',
			'description' => 'デフォルトの説明です',
		],
	];
	protected Connection $db;
	protected Auth $auth;

	public function __construct(Auth $auth, Connection $db) {
		$this->db = $db;
		$this->auth = $auth;
	}
}