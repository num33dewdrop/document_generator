<?php

namespace Models;

use PDOStatement;
use Utilities\Debug;

class Qualification extends Model {
	public function findById(string $id): array {
		$sql = "SELECT * FROM qualifications WHERE user_id = :user_id AND  id = :id AND delete_flg = 0";
		return $this->db->fetchAssoc($sql, [':user_id' => session()->get('user_id'), ':id' => $id]);
	}

	public function list(int $limit = 20): array {
		$currentPage = empty($this->paginator->getRequest()->getParam('p'))? 1: (int) $this->paginator->getRequest()->getParam('p');
		$offset = ($currentPage - 1) * $limit;
		$sql = "SELECT * FROM qualifications WHERE user_id = :user_id AND delete_flg = 0";
		$result = $this->db->fetchList($sql, [':user_id' => session()->get('user_id')], $offset, $limit);
		return [
			'list' => $result,
			'paginator' => $this->paginator->setPage($currentPage, $result['total_page'])
		];
	}

	public function create(array $posts): PDOStatement | false {
		$sql = "INSERT INTO qualifications (user_id, name, acquisition_date, create_at) VALUES (:user_id, :name, :acquisition_date, :create_at)";
		$data = [
			':user_id'          => session()->get('user_id'),
			':name'             => $posts['qualification_name'],
			':acquisition_date' => $posts['acquisition_date'],
			':create_at'        => date( 'Y-m-d H:i:s' )
		];
		$this->db->query($sql, $data);
		return $this->db->stmt;
	}

	public function update(string $id, array $posts): PDOStatement | false {
		$sql = "UPDATE qualifications SET name = :name, acquisition_date = :acquisition_date WHERE user_id = :user_id AND id = :q_id AND delete_flg = 0";
		$data = [
			':q_id'             => $id,
			':user_id'          => session()->get('user_id'),
			':name'             => $posts['qualification_name'],
			':acquisition_date' => $posts['acquisition_date']
		];
		$this->db->query($sql, $data);
		return $this->db->stmt;
	}

	public function delete(string $id): PDOStatement | false {
		$sql = "UPDATE qualifications SET delete_flg = 1 WHERE user_id = :user_id AND id = :q_id AND delete_flg = 0";
		$data = [
			':q_id'    => $id,
			':user_id' => session()->get('user_id')
		];
		$this->db->query($sql, $data);
		return $this->db->stmt;
	}
}