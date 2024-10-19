<?php

namespace Database;
use PDO;
use PDOException;
use PDOStatement;

class Connection {
	private PDO $pdo;
	public function __construct($config) {
		//DBへの接続準備
		$dsn      = "mysql:dbname={$config['database']};host={$config['host']};charset=utf8";
		$user     = $config['username'];
		$password = $config['password'];
		$options  = [
			// SQL実行失敗時にはエラーコードのみ設定
			PDO::ATTR_ERRMODE                  => PDO::ERRMODE_SILENT,
			// デフォルトフェッチモードを連想配列形式に設定
			PDO::ATTR_DEFAULT_FETCH_MODE       => PDO::FETCH_ASSOC,
			// バッファードクエリを使う(一度に結果セットをすべて取得し、サーバー負荷を軽減)
			// SELECTで得た結果に対してもrowCountメソッドを使えるようにする
			PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
		];
		try {
			// PDOオブジェクト生成（DBへ接続）
			$this->pdo = new PDO( $dsn, $user, $password, $options );
		}catch (PDOException $e) {
			// エラー時にログを記録
			error_log("データベース接続エラー: " . $e->getMessage());
		}
	}

	// 接続を取得
	public function getConnection(): PDO {
		return $this->pdo;
	}

	// 通常のクエリ実行
	public function query(string $sql, array $params = []): PDOStatement | false {
		try {
			$stmt = $this->pdo->prepare($sql);
			if ( $stmt->execute( $params ) ) {
				return $stmt;
			} else {
				error_log("Query execution failed: " . implode(", ", $stmt->errorInfo()));
				return false;
			}
		} catch (PDOException $e) {
			// エラーハンドリング
			error_log("Query preparation failed: " . $e->getMessage());
			return false;
		}
	}

	public function fetchAll(string $sql, array $params = []): array {
		try {
			$stmt = $this->query($sql, $params);
			return $stmt->fetchAll() ?: [];
		} catch (PDOException $e) {
			error_log("Data fetchAll failed: " . $e->getMessage());
			return [];
		}
	}

	public function fetchAssoc(string $sql, array $params = []): array {
		try {
			$stmt = $this->query($sql, $params);
			return $stmt->fetch( PDO::FETCH_ASSOC ) ?: [];
		} catch (PDOException $e) {
			error_log("Data fetchAssoc failed: " . $e->getMessage());
			return [];
		}
	}

}