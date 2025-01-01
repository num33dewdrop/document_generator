<?php

namespace Models;

use Database\Connection;
use PDOStatement;
use Utilities\Debug;

class WorkExperience extends Model {
	public function findById(string $id): array {
		$sql = "SELECT * FROM work_experiences
				WHERE user_id = :user_id
				AND id = :id
				AND delete_flg = 0";
		return Connection::fetchAssoc($sql, [':user_id' => session()->get('user_id'), ':id' => $id]);
	}

	public function list(int $limit = 20): array {
		$currentPage = empty($this->paginator->getRequest()->getParam('p'))? 1: (int) $this->paginator->getRequest()->getParam('p');
		$offset = ($currentPage - 1) * $limit;
		$sql = "SELECT * FROM work_experiences
				WHERE user_id = :user_id
				AND delete_flg = 0";
		$result = Connection::fetchList($sql, [':user_id' => session()->get('user_id')], $offset, $limit);
		return [
			'list' => $result,
			'paginator' => $this->paginator->setPage($currentPage, $result['total_page'])
		];
	}

	public function all(): array {
		$sql = "SELECT * FROM work_experiences
				WHERE user_id = :user_id
				AND delete_flg = 0";
		return Connection::fetchAll($sql, [':user_id' => session()->get('user_id')]);
	}

	public function create(array $posts): void {
		$sql = "INSERT INTO work_experiences (
					user_id,
					name,
					first_date,
					last_date,
					business, 
					capital_stock, 
					sales,
					number_of_employees,
					employment_status_id,
					job_summary,
					last_career_id, 
					experience,
					track_record,
					create_at
				)
				VALUES (
					:user_id,
					:name,
					:first_date,
					:last_date,
					:business, 
					:capital_stock, 
					:sales,
					:number_of_employees,
					:employment_status_id,
					:job_summary,
					:last_career_id, 
					:experience,
					:track_record,
					:create_at
				)";
		$data = [
			':user_id'             => session()->get('user_id'),
			':name'                => $posts['company_name'],
			':first_date'          => $posts['first_date'],
			':last_date'           => $posts['last_date'],
			':business'            => $posts['business'],
			':capital_stock'       => $posts['capital_stock'],
			':sales'               => $posts['sales'],
			':number_of_employees' => $posts['number_of_employees'],
			':employment_status_id'=> $posts['employment_status'],
			':job_summary'         => $posts['job_summary'],
			':last_career_id'      => $posts['last_career'],
			':experience'          => $posts['experience'],
			':track_record'        => $posts['track_record'],
			':create_at'           => date( 'Y-m-d H:i:s' )
		];
		Connection::query($sql, $data);
	}

	public function update(string $id, array $posts): void {
		$sql = "UPDATE work_experiences
				SET name = :name,
					first_date = :first_date,
					last_date = :last_date,
					business = :business,
					capital_stock = :capital_stock,
					sales = :sales,
					number_of_employees = :number_of_employees,
					employment_status_id = :employment_status_id,
					job_summary = :job_summary,
					experience = :experience,
					last_career_id = :last_career_id,
					track_record = :track_record
				WHERE user_id = :user_id
				AND id = :w_id
				AND delete_flg = 0";
		$data = [
			':w_id'                => $id,
			':user_id'             => session()->get('user_id'),
			':name'                => $posts['company_name'],
			':first_date'          => $posts['first_date'],
			':last_date'           => $posts['last_date'],
			':business'            => $posts['business'],
			':capital_stock'       => $posts['capital_stock'],
			':sales'               => $posts['sales'],
			':number_of_employees' => $posts['number_of_employees'],
			':employment_status_id'=> $posts['employment_status'],
			':job_summary'         => $posts['job_summary'],
			':experience'          => $posts['experience'],
			':last_career_id'      => $posts['last_career'],
			':track_record'        => $posts['track_record']
		];
		Connection::query($sql, $data);
	}

	public function delete(string $id): void {
		$sql = "UPDATE work_experiences
				SET delete_flg = 1
				WHERE user_id = :user_id
				AND id = :w_id
				AND delete_flg = 0";
		$data = [
			':w_id'    => $id,
			':user_id' => session()->get('user_id')
		];
		Connection::query($sql, $data);
	}
}