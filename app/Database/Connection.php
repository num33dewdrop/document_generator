<?php

namespace Database;
use PDO;
use PDOException;
use PDOStatement;
use Utilities\Debug;

class Connection {
	private PDO $pdo;
	protected array $config;
	public PDOStatement | false $stmt;

	public function __construct() {
		$this->config = require base_path('config/database.php');
		//DBへの接続準備
		$dsn      = "mysql:dbname={$this->config['database']};host={$this->config['host']};charset=utf8";
		$user     = $this->config['username'];
		$password = $this->config['password'];
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
	public function getPdo(): PDO {
		return $this->pdo;
	}

	public function bind($parameter, $value, $var_type = null): void {
		if (is_null($var_type)) {
			$var_type = match ( true ) {
				is_bool( $value ) => PDO::PARAM_BOOL,
				is_int( $value ) => PDO::PARAM_INT,
				is_null( $value ) => PDO::PARAM_NULL,
				default => PDO::PARAM_STR,
			};
		}
		$this->stmt->bindValue($parameter, $value, $var_type);
	}

	// 通常のクエリ実行
	public function query(string $sql, array $params = []): void {
		try {
			$this->stmt = $this->pdo->prepare($sql);
			foreach ($params as $parameter => $value) {
				$this->bind($parameter, $value);
			}
			if ( ! $this->stmt->execute() ) {
				Debug::echo('クエリ失敗');
				error_log("Query execution failed: " . implode(", ", $this->stmt->errorInfo()));
			}
		} catch (PDOException $e) {
			// エラーハンドリング
			error_log("Query preparation failed: " . $e->getMessage());
		}
	}

	public function fetchAll(string $sql, array $params = []): array {
		$this->query($sql, $params);
		return $this->stmt? [
			'total' => $this->stmt->rowCount(),//総レコード数
			'records' => $this->stmt->fetchAll() ?: []
		]: [];
	}

	public function fetchList(string $sql, array $params = [], int $offset = 0, int $limit = 20): array {
		$result = [];
		$this->query($sql, $params);
		if (! $this->stmt ) {
			return $result;
		}

		$result['total'] = $this->stmt->rowCount();//総レコード数
		$result['total_page'] = ceil( $result['total'] / $limit );//総ページ数
		$sql .= ' LIMIT :limit OFFSET :offset';
		$params = array_merge( $params, [':limit' => $limit, ':offset' => $offset]);

		$this->query($sql, $params);
		$result['records'] = $this->stmt? $this->stmt->fetchAll() ?: [] : [];
		$result['min'] = $this->stmt && count($result['records'])? $offset + 1: 0;
		$result['max'] = $this->stmt? $offset + count($result['records']): 0;
		return $result;
	}

	public function fetchAssoc(string $sql, array $params = []): array {
		$this->query($sql, $params);
		return $this->stmt? $this->stmt->fetch( PDO::FETCH_ASSOC ) ?: [] : [];
	}

}