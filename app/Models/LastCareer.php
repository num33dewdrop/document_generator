<?php

namespace Models;

class LastCareer extends Model {
	public function findById(string $id): array {
		$sql = "SELECT id, name,state FROM last_career WHERE id = :id AND delete_flg = 0";
		return $this->db->fetchAssoc($sql, [':id' => $id]);
	}
	public function all(string $state): array {
		$sql = "SELECT id, name FROM last_career WHERE state = :state AND delete_flg = 0";
		return $this->db->fetchAll($sql, [':state' => $state]);
	}
}