<?php

namespace App\Models;

use App\Database\Connection;

class Prefecture extends Model {
	public function all(): array {
		$sql = "SELECT id, name FROM prefectures";
		return Connection::fetchAll($sql);
	}
}