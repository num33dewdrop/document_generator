<?php

namespace Controllers;

use Database\Connection;

class Controller {
	protected array $data = [
		'head' => [
			'title' => 'HOME',
			'description' => 'デフォルトの説明です',
		],
	];
	protected Connection $db;
	public function __construct() {
		$config = require base_path('config/database.php');
		$this->db = new Connection($config);
	}
}