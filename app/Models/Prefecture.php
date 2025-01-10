<?php

namespace Models;

use Database\Connection;

class Prefecture extends Model {
	public function all(): array {
		$sql = "SELECT id, name FROM prefectures";
		return Connection::fetchAll($sql);
	}
}