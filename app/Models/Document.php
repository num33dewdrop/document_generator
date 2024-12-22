<?php

namespace Models;

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
					(
						SELECT a.academic_background_id
						FROM academic_backgrounds_display AS a
						WHERE a.document_id = d.id
					) AS academic_backgrounds,
					(
						SELECT w.work_experience_id
						FROM work_experiences_display AS w
						WHERE w.document_id = d.id
					) AS work_experiences,
					(
						SELECT q.qualifications_id
						FROM qualifications_display AS q
						WHERE q.document_id = d.id
					) AS qualifications,
					d.create_at,
					d.update_at
				FROM documents AS d
				WHERE d.user_id = :user_id
				AND d.id = :id
				AND d.delete_flg = 0";
		return $this->db->fetchAssoc($sql, [':user_id' => session()->get('user_id'), ':id' => $id]);
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
					(
						SELECT a.academic_background_id
						FROM academic_backgrounds_display AS a
						WHERE a.document_id = d.id
					) AS academic_backgrounds,
					(
						SELECT w.work_experience_id
						FROM work_experiences_display AS w
						WHERE w.document_id = d.id
					) AS work_experiences,
					(
						SELECT q.qualifications_id
						FROM qualifications_display AS q
						WHERE q.document_id = d.id
					) AS qualifications,
					d.create_at,
					d.update_at
				FROM documents AS d
				WHERE d.user_id = :user_id
				AND d.delete_flg = 0";
		$result = $this->db->fetchList($sql, [':user_id' => session()->get('user_id')], $offset, $limit);
		return [
			'list' => $result,
			'paginator' => $this->paginator->setPage($currentPage, $result['total_page'])
		];
	}

	public function create(array $posts): PDOStatement | false {
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
		$this->db->query($sql, $data);
		return $this->db->stmt;
	}

	public function update(string $id, array $posts): PDOStatement | false {
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
		$this->db->query($sql, $data);
		return $this->db->stmt;
	}

	public function delete(string $id): PDOStatement | false {
		$sql = "UPDATE documents
				SET delete_flg = 1
				WHERE user_id = :user_id
				AND id = :d_id
				AND delete_flg = 0";
		$data = [
			':d_id'    => $id,
			':user_id' => session()->get('user_id')
		];
		$this->db->query($sql, $data);
		return $this->db->stmt;
	}
}