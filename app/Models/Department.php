<?php

namespace Models;

use PDOStatement;

class Department extends Model {
	public function findById(string $id): array {
		$sql = "SELECT
					d.id,
					d.name,
					d.first_date,
					d.last_date,
					d.job_assigned,
					d.products,
					d.tasks,
					d.scale,
					d.create_at, 
					d.update_at,
					d.work_experience_id AS w_id,
					w.name AS w_name,
					w.first_date AS w_first_date,
					w.last_date AS w_last_date
				FROM departments AS d
				INNER JOIN work_experiences AS w
				ON d.work_experience_id = w.id
				WHERE w.user_id = :user_id
				AND d.id = :id
				AND d.delete_flg = 0
				AND w.delete_flg = 0";
		return $this->db->fetchAssoc($sql, [':user_id' => session()->get('user_id'), ':id' => $id]);
	}

	public function list(int $limit = 20): array {
		$currentPage = empty($this->paginator->getRequest()->getParam('p'))? 1: (int) $this->paginator->getRequest()->getParam('p');
		$offset = ($currentPage - 1) * $limit;
		$sql = "SELECT
					d.id,
					d.name,
					d.first_date,
					d.last_date,
					d.job_assigned,
					d.products,
					d.tasks,
					d.scale,
					d.create_at, 
					d.update_at,
					d.work_experience_id AS w_id,
					w.name AS w_name,
					w.first_date AS w_first_date,
					w.last_date AS w_last_date
				FROM departments AS d
				INNER JOIN work_experiences AS w
				ON d.work_experience_id = w.id
				WHERE w.user_id = :user_id
				AND d.delete_flg = 0
				AND w.delete_flg = 0";
		$result = $this->db->fetchList($sql, [':user_id' => session()->get('user_id')], $offset, $limit);
		return [
			'list' => $result,
			'paginator' => $this->paginator->setPage($currentPage, $result['total_page'])
		];
	}

	public function create(array $posts): PDOStatement | false {
		$sql = "INSERT INTO departments (
					work_experience_id,
					name,
					first_date,
					last_date,
					job_assigned,
					products,
					tasks,
					scale,
					create_at 
				)
				VALUES (
					:work_experience_id,
					:name,
					:first_date,
					:last_date,
					:job_assigned,
					:products,
					:tasks,
					:scale,
					:create_at 
				)";
		$data = [
			':work_experience_id' => $posts['work_experience_id'],
			':name'               => $posts['department_name'],
			':first_date'         => $posts['first_date'],
			':last_date'          => $posts['last_date'],
			':job_assigned'       => $posts['job_assigned'],
			':products'           => $posts['products'],
			':tasks'              => $posts['tasks'],
			':scale'              => $posts['scale'],
			':create_at'          => date( 'Y-m-d H:i:s' )
		];
		$this->db->query($sql, $data);
		return $this->db->stmt;
	}

	public function update(string $id, array $posts): PDOStatement | false {
		$sql = "UPDATE departments AS d
				INNER JOIN work_experiences AS w
				ON d.work_experience_id = w.id
				SET d.name = :name,
				    d.first_date = :first_date,
				    d.last_date = :last_date,
				    d.job_assigned = :job_assigned,
					d.products = :products,
					d.tasks = :tasks,
					d.scale = :scale
				WHERE d.id = :d_id
				AND w.user_id = :user_id
				AND d.delete_flg = 0";
		$data = [
			':a_id'           => $id,
			':user_id'        => session()->get('user_id'),
			':name'           => $posts['academic_name'],
			':first_date'     => $posts['first_date'],
			':last_date'      => $posts['last_date'],
			':last_career_id' => $posts['last_career']
		];
		$this->db->query($sql, $data);
		return $this->db->stmt;
	}
}