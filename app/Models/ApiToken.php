<?php

namespace Models;

use Exception;
use PDOStatement;

class ApiToken extends Model {
	/**
	 * トークンを生成
	 *
	 * @param string $userId クライアントのuserId
	 * @return PDOStatement | false PDOStatementを返すか、失敗の場合はfalse
	 */
	public function create(string $userId): PDOStatement | false {
		$expires_at = date( 'Y-m-d H:i:s', strtotime( '+1 hour' ) ); // 有効期限: 1時間後
		$sql = "INSERT INTO api_tokens (user_id, token, expires_at, created_at) VALUES (:user_id, :token, :expires_at, :create_at)";
		$data = [
			":user_id" => $userId,
			":token" => token(),
			":expires_at" => $expires_at,
			":create_at" => date( 'Y-m-d H:i:s' )
		];
		// データベースに保存
		$this->db->query( $sql, $data );
		return $this->db->stmt;
	}

	/**
	 * トークンを更新
	 *
	 * @param string $userId クライアントのuserId
	 * @return PDOStatement | false PDOStatementを返すか、失敗の場合はfalse
	 */
	public function update (string $userId): PDOStatement | false {
		$expires_at = date( 'Y-m-d H:i:s', strtotime( '+1 hour' ) ); // 有効期限: 1時間後
		$sql = "UPDATE api_tokens SET token = :token, expires_at = :expires_at  WHERE user_id = :user_id";
		$data = [
			":user_id" => $userId,
			":token" => token(),
			":expires_at" => $expires_at
		];
		// データベースに保存
		$this->db->query( $sql, $data );
		return $this->db->stmt;
	}

//	public function getToken(): array {
//		$sql = "SELECT token FROM api_tokens WHERE user_id = :user_id";
//		$data = [':user_id' => session()->get('user_id')];
//		// トークンが有効な場合、true
//		return $this->db->fetchAssoc($sql, $data);
//	}

	/**
	 * トークンを検証
	 *
	 * @param string $token クライアントから送信されたトークン
	 *
	 * @return array 無効の場合はfalse
	 */
	public function check(string $token ): array {
		$sql = "SELECT count(*) FROM api_tokens WHERE token = :token";
		$data = [':token' => $token];
		// トークンが有効な場合、true
		return $this->db->fetchAssoc($sql, $data);
	}

	/**
	 * トークンを無効化
	 *
	 * @param string $token トークン
	 * @return void
	 */
	public function revokeToken(string $token): void {
		$sql = "DELETE FROM api_tokens WHERE token = :token";
		$data = [':token' => $token];
		$this->db->query($sql, $data);
	}
}