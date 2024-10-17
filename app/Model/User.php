<?php

namespace Model;

use Database\Connection;

class User {
	private Connection $db;

	public function __construct(Connection $db) {
		$this->db = $db;
	}

	public function findById(int $id): array {
		$sql = "SELECT * FROM users WHERE id = :id";
		return $this->db->fetchAssoc($sql, [':id' => $id]);
	}

	public function findByEmail(string $email): array {
		$sql = "SELECT * FROM users WHERE email = :email";
		return $this->db->fetchAssoc($sql, [':email' => $email]);
	}

	public function create(array $data): bool {
		$sql = "INSERT INTO users (name, email, password, create_at) VALUES (:name, :email, :password, :create_at)";
		return $this->db->query($sql, $data);
	}
}