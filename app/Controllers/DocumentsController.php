<?php
namespace Controllers;
use Utilities\Debug;

class DocumentsController {
	public static function index(): void {
		Debug::start('HOME');
		Debug::echo('テスト');
		$data = array(
			'head' => array(
				"title" => 'HOME',
				"description" => 'サイトの説明です',
				"config" => require base_path('config/app.php')
			)
		);
		// ビューにデータを渡して表示
		view('documents/document-list', $data);
	}
}