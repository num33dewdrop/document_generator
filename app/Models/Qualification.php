<?php

namespace App\Models;

use App\Database\Connection;
use PDOStatement;
use App\Utilities\Debug;

class Qualification extends Model {
	public function findById(string $id): array {
		$sql = "SELECT * FROM qualifications WHERE user_id = :user_id AND  id = :id AND delete_flg = 0";
		return Connection::fetchAssoc($sql, [':user_id' => session()->get('user_id'), ':id' => $id]);
	}

	public function findByIds(array $ids): array {
		$sql = "SELECT
					q.id,
					q.user_id,
					q.name,
					q.acquisition_date
				FROM qualifications AS q 
				WHERE q.id IN (:ids)
				AND q.user_id = :user_id
				AND q.delete_flg = 0";
		return Connection::fetchAll($sql, [':user_id' => session()->get('user_id'), 'ids' => $ids]);
	}

	public function list(int $limit = 20): array {
		$currentPage = empty($this->paginator->getRequest()->getParam('p'))? 1: (int) $this->paginator->getRequest()->getParam('p');
		$offset = ($currentPage - 1) * $limit;
		$sql = "SELECT * FROM qualifications
				WHERE user_id = :user_id
				AND delete_flg = 0";
		$result = Connection::fetchList($sql, [':user_id' => session()->get('user_id')], $offset, $limit);
		return [
			'list' => $result,
			'paginator' => $this->paginator->setPage($currentPage, $result['total_page'])
		];
	}

	public function all(): array {
		$sql = "SELECT * FROM qualifications
				WHERE user_id = :user_id
				AND delete_flg = 0";
		return Connection::fetchAll($sql, [':user_id' => session()->get('user_id')]);
	}

	public function create(array $posts): void {
		$sql = "INSERT INTO qualifications (
					user_id,
					name,
					acquisition_date,
					create_at
				)
				VALUES (
					:user_id,
					:name,
					:acquisition_date,
					:create_at
				)";
		$data = [
			':user_id'          => session()->get('user_id'),
			':name'             => $posts['qualification_name'],
			':acquisition_date' => $posts['acquisition_date'],
			':create_at'        => date( 'Y-m-d H:i:s' )
		];
		Connection::query($sql, $data);
	}

	public function update(string $id, array $posts): void {
		$sql = "UPDATE qualifications
				SET name = :name,
				    acquisition_date = :acquisition_date
				WHERE user_id = :user_id
				AND id = :q_id
				AND delete_flg = 0";
		$data = [
			':q_id'             => $id,
			':user_id'          => session()->get('user_id'),
			':name'             => $posts['qualification_name'],
			':acquisition_date' => $posts['acquisition_date']
		];
		Connection::query($sql, $data);
	}

	public function delete(string $id): void {
		$sql = "UPDATE qualifications
				SET delete_flg = 1
				WHERE user_id = :user_id
				AND id = :q_id
				AND delete_flg = 0";
		$data = [
			':q_id'    => $id,
			':user_id' => session()->get('user_id')
		];
		Connection::query($sql, $data);
	}
}