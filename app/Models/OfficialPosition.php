<?php

namespace Models;

class OfficialPosition extends Model {
	public function findById(string $id): array {
		$sql = "SELECT
					o.id,
					o.name,
					o.first_date,
					o.last_date,
					o.scale,
					o.create_at, 
					o.update_at,
					o.work_experience_id AS w_id,
					w.name AS w_name,
					w.first_date AS w_first_date,
					w.last_date AS w_last_date
				FROM official_position AS o
				INNER JOIN work_experiences AS w
				ON o.work_experience_id = w.id
				WHERE w.user_id = :user_id
				AND o.id = :id
				AND o.delete_flg = 0
				AND w.delete_flg = 0";
		return $this->db->fetchAssoc($sql, [':user_id' => session()->get('user_id'), ':id' => $id]);
	}
}