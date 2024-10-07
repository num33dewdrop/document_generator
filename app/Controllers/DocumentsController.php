<?php

namespace Controllers;

class DocumentsController {
	public static function index(): void {

		// ビューにデータを渡して表示
		view('documents/document-list');
	}
}