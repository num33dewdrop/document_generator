<?php

namespace App\Models;

use App\Database\Connection;

class AcademicBackgroundsDisplay extends Model {
	public function all(string $d_id): array {
		$sql = "SELECT academic_background_id
				FROM academic_backgrounds_display
				WHERE document_id = :d_id";
		$data = [':d_id' => $d_id ];
		return Connection::fetchAll($sql, $data);
	}
	public function create(string $d_id, string $a_id): void {
		$sql = "INSERT INTO academic_backgrounds_display (
					document_id,
					academic_background_id,
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

	public function remove(string $d_id, string $a_id) {
		$sql = "DELETE ad
				FROM academic_backgrounds_display AS ad
				INNER JOIN documents AS d ON ad.document_id = d.id
				WHERE d.id = :d_id
				AND d.user_id = :user_id
				AND ad.academic_background_id = :a_id";
		$data = [
			':d_id'      => $d_id,
			':a_id'      => $a_id,
			':user_id'   => session()->get('user_id'),
		];
		Connection::query($sql, $data);
	}
}