<?php

namespace App\Models;

use App\Database\Connection;
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
		return Connection::fetchAssoc($sql, [':user_id' => session()->get('user_id'), ':id' => $id]);
	}

	public function list(string $w_id, int $limit = 20): array {
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
					d.work_experience_id AS w_id
				FROM departments AS d
				INNER JOIN work_experiences AS w
				ON d.work_experience_id = w.id
				WHERE w.user_id = :user_id
				AND d.work_experience_id = :w_id
				AND d.delete_flg = 0
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
				SELECT 
					w.id,
					:name,
					:first_date,
					:last_date,
					:job_assigned,
					:products,
					:tasks,
					:scale,
					:create_at 
				FROM work_experiences AS w
                WHERE w.id = :work_experience_id
                AND w.user_id = :user_id";
		$data = [
			':work_experience_id' => $w_id,
			':name'               => $posts['department_name'],
			':first_date'         => $posts['first_date'],
			':last_date'          => $posts['last_date'],
			':job_assigned'       => $posts['job_assigned'],
			':products'           => $posts['products'],
			':tasks'              => $posts['tasks'],
			':scale'              => $posts['scale'],
			':user_id'            => session()->get('user_id'),
			':create_at'          => date( 'Y-m-d H:i:s' )
		];
		Connection::query($sql, $data);
	}

	public function update(string $d_id, array $posts): void {
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
			':d_id'           => $d_id,
			':user_id'        => session()->get('user_id'),
			':name'               => $posts['department_name'],
			':first_date'         => $posts['first_date'],
			':last_date'          => $posts['last_date'],
			':job_assigned'       => $posts['job_assigned'],
			':products'           => $posts['products'],
			':tasks'              => $posts['tasks'],
			':scale'              => $posts['scale'],
		];
		Connection::query($sql, $data);
	}

	public function delete(string $id): void {
		$sql = "UPDATE departments AS d
				INNER JOIN work_experiences AS w
				ON d.work_experience_id = w.id
				SET d.delete_flg = 1
				WHERE w.user_id = :user_id
				AND d.id = :d_id
				AND d.delete_flg = 0";
		$data = [
			':d_id'    => $id,
			':user_id' => session()->get('user_id')
		];
		Connection::query($sql, $data);
	}
}