<?php

namespace App\Models;

use App\Database\Connection;

class WorkExperiencesDisplay extends Model {
	public function all(string $d_id): array {
		$sql = "SELECT work_experience_id
				FROM work_experiences_display
				WHERE document_id = :d_id";
		$data = [':d_id' => $d_id ];
		return Connection::fetchAll($sql, $data);
	}
	public function create(string $d_id, string $w_id): void {
		$sql = "INSERT INTO work_experiences_display (
					document_id,
					work_experience_id,
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
			':a_id'      => $w_id,
			':user_id'   => session()->get('user_id'),
			':create_at' => date( 'Y-m-d H:i:s' )
		];
		Connection::query($sql, $data);
	}

	public function remove(string $d_id, string $w_id) {
		$sql = "DELETE wd
				FROM work_experiences_display AS wd
				INNER JOIN documents AS d ON wd.document_id = d.id
				WHERE d.id = :d_id
				AND d.user_id = :user_id
				AND wd.work_experience_id = :w_id";
		$data = [
			':d_id'      => $d_id,
			':w_id'      => $w_id,
			':user_id'   => session()->get('user_id'),
		];
		Connection::query($sql, $data);
	}
}