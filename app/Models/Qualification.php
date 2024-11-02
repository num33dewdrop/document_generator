<?php

namespace Models;

use PDOStatement;

class Qualification extends Model {
	public function findById(int $id): array {
		$sql = "SELECT * FROM qualifications WHERE id = :id";
		return $this->db->fetchAssoc($sql, [':id' => $id]);
	}

	public function create(array $posts): PDOStatement | false {
		$sql = "INSERT INTO qualifications (user_id, name, acquisition_date, create_at) VALUES (:user_id, :name, :acquisition_date, :create_at)";
		$data = [
			':user_id'          => session()->get('user_id'),
			':name'             => $posts['qualification_name'],
			':acquisition_date' => $posts['acquisition_date'],
			':create_at'        => date( 'Y-m-d H:i:s' )
		];
		return $this->db->query($sql, $data);
	}
}