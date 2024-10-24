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

	public function __construct() {
		$config = require base_path('config/database.php');
		$this->db = new Connection($config);
		$this->auth = new Auth($this->db);
	}
}