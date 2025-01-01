<?php

namespace Models;

use Database\Connection;
use PDOStatement;

class User extends Model {
	public function findById(int $id): array {
		$sql = "SELECT * FROM users
				WHERE id = :id
				AND delete_flg = 0";
		return Connection::fetchAssoc($sql, [':id' => $id]);
	}

	public function findByEmail(string $email): array {
		$sql = "SELECT * FROM users
				WHERE email = :email";
		return Connection::fetchAssoc($sql, [':email' => $email]);
	}

	public function create(array $posts): void {
		$sql  = "INSERT INTO users (
					name,
					email,
					password,
					create_at
				)
				VALUES (
					:name,
					:email,
					:password,
					:create_at
				)";
		$data = [
			':name'      => $posts['name'],
			':email'     => $posts['email'],
			':password'  => password_hash( $posts['password'], PASSWORD_DEFAULT ),
			':create_at' => date( 'Y-m-d H:i:s' )
		];
		Connection::query( $sql, $data );
	}
}