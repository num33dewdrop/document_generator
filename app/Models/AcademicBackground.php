<?php

namespace App\Models;

use App\Database\Connection;
use App\Utilities\Paginator;
use PDOStatement;
use App\Utilities\Debug;

class AcademicBackground extends Model{
	public function findById(string $id): array {
		$sql = "SELECT * FROM academic_backgrounds
				WHERE user_id = :user_id
				AND id = :id
				AND delete_flg = 0";
		return Connection::fetchAssoc($sql, [':user_id' => session()->get('user_id'), ':id' => $id]);
	}

	public function findByIds(array $ids): array {
		$sql = "SELECT
					a.id,
					a.user_id,
					a.name,
					a.first_date,
					a.last_date,
					a.last_career_id,
					lc.name AS last_career
				FROM academic_backgrounds AS a
				LEFT JOIN last_career AS lc ON lc.id = a.last_career_id
				WHERE a.id IN (:ids)
				AND a.user_id = :user_id
				AND a.delete_flg = 0";
		return Connection::fetchAll($sql, [':user_id' => session()->get('user_id'), 'ids' => $ids]);
	}

	public function list(int $limit = 20): array {
		$currentPage = empty($this->paginator->getRequest()->getParam('p'))? 1: (int) $this->paginator->getRequest()->getParam('p');
		$offset = ($currentPage - 1) * $limit;
		$sql = "SELECT * FROM academic_backgrounds
				WHERE user_id = :user_id
				AND delete_flg = 0";
		$result = Connection::fetchList($sql, [':user_id' => session()->get('user_id')], $offset, $limit);
		return [
			'list' => $result,
			'paginator' => $this->paginator->setPage($currentPage, $result['total_page'])
		];
	}

	public function all(): array {
		$sql = "SELECT * FROM academic_backgrounds
				WHERE user_id = :user_id
				AND delete_flg = 0";
		return Connection::fetchAll($sql, [':user_id' => session()->get('user_id')]);
	}

	public function create(array $posts): void {
		$sql = "INSERT INTO academic_backgrounds (
					user_id,
					name,
					first_date,
					last_date,
					last_career_id,
					create_at
				)
				VALUES (
					:user_id,
					:name,
					:first_date,
					:last_date,
					:last_career_id,
					:create_at
				)";
		$data = [
			':user_id'        => session()->get('user_id'),
			':name'           => $posts['academic_name'],
			':first_date'     => $posts['first_date'],
			':last_date'      => $posts['last_date'],
			':last_career_id' => $posts['last_career'],
			':create_at'      => date( 'Y-m-d H:i:s' )
		];
		Connection::query($sql, $data);
	}

	public function update(string $id, array $posts): void {
		$sql = "UPDATE academic_backgrounds
				SET name = :name,
				    first_date = :first_date,
				    last_date = :last_date,
				    last_career_id = :last_career_id
				WHERE user_id = :user_id
				AND id = :a_id
				AND delete_flg = 0";
		$data = [
			':a_id'           => $id,
			':user_id'        => session()->get('user_id'),
			':name'           => $posts['academic_name'],
			':first_date'     => $posts['first_date'],
			':last_date'      => $posts['last_date'],
			':last_career_id' => $posts['last_career']
		];
		Connection::query($sql, $data);
	}

	public function delete(string $id): void {
		$sql = "UPDATE academic_backgrounds
				SET delete_flg = 1
				WHERE user_id = :user_id
				AND id = :a_id
				AND delete_flg = 0";
		$data = [
			':a_id'    => $id,
			':user_id' => session()->get('user_id')
		];
		Connection::query($sql, $data);
	}
}