<?php

namespace App\Models;

use App\Database\Connection;
use PDOStatement;

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
		return Connection::fetchAssoc($sql, [':user_id' => session()->get('user_id'), ':id' => $id]);
	}

	public function list(string $w_id, int $limit = 20): array {
		$currentPage = empty($this->paginator->getRequest()->getParam('p'))? 1: (int) $this->paginator->getRequest()->getParam('p');
		$offset = ($currentPage - 1) * $limit;
		$sql = "SELECT
					o.id,
					o.name,
					o.first_date,
					o.last_date,
					o.scale,
					o.create_at, 
					o.update_at,
					o.work_experience_id AS w_id
				FROM official_position AS o
				INNER JOIN work_experiences AS w
				ON o.work_experience_id = w.id
				WHERE w.user_id = :user_id
				AND o.work_experience_id = :w_id
				AND o.delete_flg = 0
				AND w.delete_flg = 0";
		$data = [
			'user_id' => session()->get('user_id'),
			'w_id' => $w_id
		];
		$result = Connection::fetchList($sql, $data, $offset, $limit);
		return [
			'list' => $result,
			'paginator' => $this->paginator->setPage($currentPage, $result['total_page'])
		];
	}

	public function create(string $w_id, array $posts): void {
		$sql = "INSERT INTO official_position (
					work_experience_id,
					name,
					first_date,
					last_date,
					scale,
					create_at 
				)
				SELECT 
					w.id,
					:name,
					:first_date,
					:last_date,
					:scale,
					:create_at 
				FROM work_experiences AS w
                WHERE w.id = :work_experience_id
                AND w.user_id = :user_id";
		$data = [
			':work_experience_id' => $w_id,
			':name'               => $posts['official_position_name'],
			':first_date'         => $posts['first_date'],
			':last_date'          => $posts['last_date'],
			':scale'              => $posts['scale'],
			':user_id'            => session()->get('user_id'),
			':create_at'          => date( 'Y-m-d H:i:s' )
		];
		Connection::query($sql, $data);
	}

	public function update(string $o_id, array $posts): void {
		$sql = "UPDATE official_position AS o
				INNER JOIN work_experiences AS w
				ON o.work_experience_id = w.id
				SET o.name = :name,
				    o.first_date = :first_date,
				    o.last_date = :last_date,
					o.scale = :scale
				WHERE o.id = :o_id
				AND w.user_id = :user_id
				AND o.delete_flg = 0";
		$data = [
			':o_id'       => $o_id,
			':user_id'    => session()->get('user_id'),
			':name'       => $posts['official_position_name'],
			':first_date' => $posts['first_date'],
			':last_date'  => $posts['last_date'],
			':scale'      => $posts['scale'],
		];
		Connection::query($sql, $data);
	}

	public function delete(string $id): void {
		$sql = "UPDATE official_position AS o
				INNER JOIN work_experiences AS w
				ON o.work_experience_id = w.id
				SET o.delete_flg = 1
				WHERE w.user_id = :user_id
				AND o.id = :o_id
				AND o.delete_flg = 0";
		$data = [
			':o_id'    => $id,
			':user_id' => session()->get('user_id')
		];
		Connection::query($sql, $data);
	}
}