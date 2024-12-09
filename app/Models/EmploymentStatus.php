<?php

namespace Models;

class EmploymentStatus extends Model {
	public function findById(string $id): array {
		$sql = "SELECT id, name FROM employment_status
				WHERE id = :id
				AND delete_flg = 0";
		return $this->db->fetchAssoc($sql, [':id' => $id]);
	}
	public function all(): array {
		$sql = "SELECT id, name FROM employment_status
				WHERE delete_flg = 0";
		return $this->db->fetchAll($sql);
	}
}