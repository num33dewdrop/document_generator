<?php

namespace Models;

use Database\Connection;
use PDOStatement;

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

	public function create(array $posts): PDOStatement | false {
		$sql = "INSERT INTO users (name, email, password, create_at) VALUES (:name, :email, :password, :create_at)";
		$data = [
			':name'      => $posts['name'],
			':email'     => $posts['email'],
			':password'  => password_hash( $posts['password'], PASSWORD_DEFAULT ),
			':create_at' => date( 'Y-m-d H:i:s' )
		];
		return $this->db->query($sql, $data);
	}
}