<?php

namespace App\Models;

use App\Database\Connection;

class EmploymentStatus extends Model {
	public function findById(string $id): array {
		$sql = "SELECT id, name FROM employment_status
				WHERE id = :id
				AND delete_flg = 0";
		return Connection::fetchAssoc($sql, [':id' => $id]);
	}
	public function all(): array {
		$sql = "SELECT id, name FROM employment_status
				WHERE delete_flg = 0";
		return Connection::fetchAll($sql);
	}
}