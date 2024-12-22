<?php

namespace Models;

use PDOStatement;
use Utilities\Debug;

class AcademicBackground extends Model{
	public function findById(string $id): array {
		$sql = "SELECT * FROM academic_backgrounds
				WHERE user_id = :user_id
				AND id = :id
				AND delete_flg = 0";
		return $this->db->fetchAssoc($sql, [':user_id' => session()->get('user_id'), ':id' => $id]);
	}

	public function list(int $limit = 20): array {
		$currentPage = empty($this->paginator->getRequest()->getParam('p'))? 1: (int) $this->paginator->getRequest()->getParam('p');
		$offset = ($currentPage - 1) * $limit;
		$sql = "SELECT * FROM academic_backgrounds
				WHERE user_id = :user_id
				AND delete_flg = 0";
		$result = $this->db->fetchList($sql, [':user_id' => session()->get('user_id')], $offset, $limit);
		return [
			'list' => $result,
			'paginator' => $this->paginator->setPage($currentPage, $result['total_page'])
		];
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
		$this->db->query($sql, $data);
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
		$this->db->query($sql, $data);
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
		$this->db->query($sql, $data);
	}
}