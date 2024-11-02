<?php
namespace Http\Controllers;
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

	public function register():void {
		Debug::start('DOCUMENT REGISTER');
		$this->data['head']['title'] = 'DOCUMENT REGISTER';
		$this->data['head']['description'] = 'DOCUMENT REGISTERの説明';
		// ビューにデータを渡して表示
		view('documents.document-register', $this->data);
		Debug::end('DOCUMENT REGISTER');
	}

	public function edit():void {
		Debug::start('DOCUMENT EDIT');
		$this->data['head']['title'] = 'DOCUMENT EDIT';
		$this->data['head']['description'] = 'DOCUMENT EDITの説明';
		// ビューにデータを渡して表示
		view('documents.document-register', $this->data);
		Debug::end('DOCUMENT EDIT');
	}

	public function copy():void {
		Debug::start('DOCUMENT COPY');
		$this->data['head']['title'] = 'DOCUMENT COPY';
		$this->data['head']['description'] = 'DOCUMENT COPYの説明';
		// ビューにデータを渡して表示
		view('documents.document-register', $this->data);
		Debug::end('DOCUMENT COPY');
	}

	public function create():void {
		Debug::start('DOCUMENT REGISTER STORE');

		Debug::end('DOCUMENT REGISTER STORE');
	}

	public function update():void {
		Debug::start('DOCUMENT EDIT STORE');

		Debug::end('DOCUMENT EDIT STORE');
	}

	public function duplication():void {
		Debug::start('DOCUMENT COPY STORE');

		Debug::end('DOCUMENT COPY STORE');
	}

	public function delete():void {
		Debug::start('DOCUMENT DELETE');

		Debug::end('DOCUMENT DELETE');
	}

	public function export():void {
		Debug::start('DOCUMENT EXPORT');

		Debug::end('DOCUMENT EXPORT');
	}
}