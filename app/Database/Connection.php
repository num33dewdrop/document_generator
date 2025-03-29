<?php

namespace App\Database;
use App\Utilities\Debug;
use PDO;
use PDOException;
use PDOStatement;

class Connection {
	private static array $config;
	public static PDOStatement | false $stmt;
	public static ?PDO $pdo = null;

	public static function setup(): void {
		if (self::$pdo === null) {
			self::$config = require base_path('config/database.php');
			//DBへの接続準備
			$dsn      = "mysql:dbname=".self::$config['database'].";host=".self::$config['host'].";charset=utf8";
			$user     = self::$config['username'];
			$password = self::$config['password'];
			$options  = [
				// SQL実行失敗時にはエラーコードのみ設定
				PDO::ATTR_ERRMODE                  => PDO::ERRMODE_EXCEPTION,
				// デフォルトフェッチモードを連想配列形式に設定
				PDO::ATTR_DEFAULT_FETCH_MODE       => PDO::FETCH_ASSOC,
				// バッファードクエリを使う(一度に結果セットをすべて取得し、サーバー負荷を軽減)
				// SELECTで得た結果に対してもrowCountメソッドを使えるようにする
				PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
			];
			try {
				// PDOオブジェクト生成（DBへ接続）
				self::$pdo = new PDO( $dsn, $user, $password, $options );
			}catch (PDOException $e) {
				// エラー時にログを記録
				throw new PDOException("データベース接続エラー: " . $e->getMessage(), 500);
			}
		}
	}

	public static function getPdo (): PDO {
		return self::$pdo;
	}

	public static function impacted (): bool {
		return self::$stmt && self::$stmt->rowCount() > 0;
	}

	// トランザクション開始
	public static function beginTransaction(): void {
		self::$pdo->beginTransaction();
	}

	// トランザクションコミット
	public static function commit(): void {
		self::$pdo->commit();
	}

	// トランザクションロールバック
	public static function rollback(): void {
		self::$pdo->rollBack();
	}

	private static function bind($parameter, $value): void {
		self::$stmt->bindValue($parameter, $value, self::getPdoType($value));
	}

	private static function getPdoType($value): int {
		return match (true) {
			is_bool($value) => PDO::PARAM_BOOL,
			is_int($value) => PDO::PARAM_INT,
			is_null($value) => PDO::PARAM_NULL,
			default => PDO::PARAM_STR,
		};
	}

	// 通常のクエリ実行
	public static function query(string $sql, array $params = []): void {
		try {
			// 配列を持つパラメータをプレースホルダに変換
			foreach ($params as $key1 => $value) {
				if (is_array($value)) {
					$placeholders = "";
					foreach ($value as $key2 => $item) {
						$placeholders .= ":".rtrim($key1, "s").($key2+1).",";
						$params[":".rtrim($key1, "s").($key2+1)] = $item; // 配列要素を順番に追加
					}
					$placeholders = rtrim($placeholders, ',');
					$sql = str_replace(":$key1", $placeholders, $sql);
					unset($params[$key1]);
				}
			}

			self::$stmt = self::$pdo->prepare($sql);

			// バインド処理
			foreach ($params as $parameter => $value) {
				self::bind($parameter, $value);
			}
			self::$stmt->execute();
		} catch (PDOException $e) {
			throw new PDOException("クエリ失敗: " . $e->getMessage(), 500);
		}
	}

	public static function fetchAll(string $sql, array $params = []): array {
		self::query($sql, $params);
		return self::$stmt? [
			'total' => self::$stmt->rowCount(),//総レコード数
			'records' => self::$stmt->fetchAll() ?: []
		]: [];
	}

	public static function fetchList(string $sql, array $params = [], int $offset = 0, int $limit = 20): array {
		$result = [];
		self::query($sql, $params);
		if (! self::$stmt ) {
			return $result;
		}

		$result['total'] = self::$stmt->rowCount();//総レコード数
		$result['total_page'] = ceil( $result['total'] / $limit );//総ページ数
		$sql .= ' LIMIT :limit OFFSET :offset';
		$params = array_merge( $params, [':limit' => $limit, ':offset' => $offset]);

		self::query($sql, $params);
		$result['records'] = self::$stmt? self::$stmt->fetchAll() ?: [] : [];
		$result['min'] = self::$stmt && count($result['records'])? $offset + 1: 0;
		$result['max'] = self::$stmt? $offset + count($result['records']): 0;
		return $result;
	}

	public static function fetchAssoc(string $sql, array $params = []): array {
		self::query($sql, $params);
		return self::$stmt? self::$stmt->fetch( PDO::FETCH_ASSOC ) ?: [] : [];
	}

}