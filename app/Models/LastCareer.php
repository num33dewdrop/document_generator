<?php

namespace App\Models;

use App\Database\Connection;

class LastCareer extends Model {
	public function findById(string $id): array {
		$sql = "SELECT id, name,state FROM last_career
				WHERE id = :id
				AND delete_flg = 0";
		return Connection::fetchAssoc($sql, [':id' => $id]);
	}
	public function all(string $state): array {
		$sql = "SELECT id, name FROM last_career
				WHERE state = :state
				AND delete_flg = 0";
		return Connection::fetchAll($sql, [':state' => $state]);
	}
}