<?php

namespace App\Models;

use App\Database\Connection;

class QualificationsDisplay extends Model {
	public function all(string $d_id): array {
		$sql = "SELECT qualification_id
				FROM qualifications_display
				WHERE document_id = :d_id";
		$data = [':d_id' => $d_id ];
		return Connection::fetchAll($sql, $data);
	}
	public function create(string $d_id, string $a_id): void {
		$sql = "INSERT INTO qualifications_display (
					document_id,
					qualification_id,
					create_at
				)
				SELECT
					d.id,
					:a_id,
					:create_at
				FROM documents AS d
				WHERE d.id = :d_id
				AND d.user_id = :user_id";
		$data = [
			':d_id'      => $d_id,
			':a_id'      => $a_id,
			':user_id'   => session()->get('user_id'),
			':create_at' => date( 'Y-m-d H:i:s' )
		];
		Connection::query($sql, $data);
	}

	public function remove(string $d_id, string $q_id) {
		$sql = "DELETE qd
				FROM qualifications_display AS qd
				INNER JOIN documents AS d ON qd.document_id = d.id
				WHERE d.id = :d_id
				AND d.user_id = :user_id
				AND qd.qualification_id = :q_id";
		$data = [
			':d_id'      => $d_id,
			':a_id'      => $q_id,
			':user_id'   => session()->get('user_id'),
		];
		Connection::query($sql, $data);
	}
}