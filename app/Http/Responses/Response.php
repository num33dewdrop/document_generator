<?php

namespace Http\Responses;

class Response {
	/**
	 * JSONレスポンスを生成
	 *
	 * @param array $data レスポンスデータ
	 * @param int $status ステータスコード
	 * @param array $headers ヘッダー情報
	 * @return void
	 */
	public function json(array $data, int $status = 200, array $headers = []): void {
		// ヘッダーを設定
		header('Content-Type: application/json', true, $status);
		foreach ($headers as $key => $value) {
			header("{$key}: {$value}");
		}
		// JSONデータを出力
		echo json_encode($data);
		exit; // スクリプトを終了
	}

	/**
	 * テキストレスポンスを生成
	 *
	 * @param string $content レスポンス内容
	 * @param int $status ステータスコード
	 * @param array $headers ヘッダー情報
	 * @return void
	 */
	public function text(string $content, int $status = 200, array $headers = []): void {
		// ヘッダーを設定
		foreach ($headers as $key => $value) {
			header("{$key}: {$value}", true, $status);
		}
		// テキストデータを出力
		echo $content;
		exit; // スクリプトを終了
	}
}