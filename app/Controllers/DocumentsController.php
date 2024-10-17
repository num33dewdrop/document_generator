<?php
namespace Controllers;
use Utilities\Debug;

class DocumentsController extends Controller {
	public function list(): void {
		Debug::start('DOCUMENT LIST');
		$this->data['head']['title'] = 'DOCUMENT LIST';
		$this->data['head']['description'] = 'DOCUMENT LISTの説明';
		// ビューにデータを渡して表示
		view('documents.document-list', $this->data);
		Debug::end('DOCUMENT LIST');
	}
}