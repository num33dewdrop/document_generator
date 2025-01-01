<?php

namespace Models;

use Database\Connection;
use PDOStatement;

class Document extends Model {
	public function findById(string $id): array {
		$sql = "SELECT
					d.id,
					d.user_id,
					d.name,
					d.pr,
					d.supplement,
					d.wish,
					GROUP_CONCAT(DISTINCT a.academic_background_id) AS academic_backgrounds,
					GROUP_CONCAT(DISTINCT w.work_experience_id) AS work_experiences,
					GROUP_CONCAT(DISTINCT q.qualification_id) AS qualifications,
					d.create_at,
					d.update_at
				FROM documents AS d
				LEFT JOIN academic_backgrounds_display AS a ON a.document_id = d.id
				LEFT JOIN work_experiences_display AS w ON w.document_id = d.id
				LEFT JOIN qualifications_display AS q ON q.document_id = d.id
				WHERE d.user_id = :user_id
				AND d.id = :id
				AND d.delete_flg = 0
				GROUP BY d.id";
		return Connection::fetchAssoc($sql, [':user_id' => session()->get('user_id'), ':id' => $id]);
	}

	public function list(int $limit = 20): array {
		$currentPage = empty($this->paginator->getRequest()->getParam('p'))? 1: (int) $this->paginator->getRequest()->getParam('p');
		$offset = ($currentPage - 1) * $limit;
		$sql = "SELECT
					d.id,
					d.user_id,
					d.name,
					d.pr,
					d.supplement,
					d.wish,
					GROUP_CONCAT(DISTINCT a.academic_background_id) AS academic_backgrounds,
					GROUP_CONCAT(DISTINCT w.work_experience_id) AS work_experiences,
					GROUP_CONCAT(DISTINCT q.qualification_id) AS qualifications,
					d.create_at,
					d.update_at
				FROM documents AS d
				LEFT JOIN academic_backgrounds_display AS a ON a.document_id = d.id
				LEFT JOIN work_experiences_display AS w ON w.document_id = d.id
				LEFT JOIN qualifications_display AS q ON q.document_id = d.id
				WHERE d.user_id = :user_id
				AND d.delete_flg = 0
				GROUP BY d.id";
		$result = Connection::fetchList($sql, [':user_id' => session()->get('user_id')], $offset, $limit);
		return [
			'list' => $result,
			'paginator' => $this->paginator->setPage($currentPage, $result['total_page'])
		];
	}

	public function create(array $posts): void {
		$sql = "INSERT INTO documents (
					user_id,
					name,
					pr,
					supplement,
					wish,
					create_at
				)
				VALUES (
					:user_id,
					:name,
					:pr,
					:supplement,
					:wish,
					:create_at
				)";
		$data = [
			':user_id'    => session()->get('user_id'),
			':name'       => $posts['document_name'],
			':pr'         => $posts['pr'],
			':supplement' => $posts['supplement'],
			':wish'       => $posts['wish'],
			':create_at'  => date( 'Y-m-d H:i:s' )
		];
		Connection::query($sql, $data);
	}

	public function update(string $id, array $posts): void {
		$sql = "UPDATE documents
				SET name = :name,
					pr = :pr,
					supplement = :supplement,
					wish = :wish
				WHERE user_id = :user_id
				AND id = :d_id
				AND delete_flg = 0";
		$data = [
			':d_id'       => $id,
			':user_id'    => session()->get('user_id'),
			':name'       => $posts['document_name'],
			':pr'         => $posts['pr'],
			':supplement' => $posts['supplement'],
			':wish'       => $posts['wish']
		];
		Connection::query($sql, $data);
	}

	public function delete(string $id): void {
		$sql = "UPDATE documents
				SET delete_flg = 1
				WHERE user_id = :user_id
				AND id = :d_id
				AND delete_flg = 0";
		$data = [
			':d_id'    => $id,
			':user_id' => session()->get('user_id')
		];
		Connection::query($sql, $data);
	}
}